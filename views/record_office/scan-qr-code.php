<?php require 'template/top-template.php'; ?>
<?php require '../../connection.php'; ?>

<div
    class="border-b border-gray-900/10 p-12 rounded-md bg-neutral-50 w-[95%] self-center my-10 grid place-content-center">
    <div class="flex flex-col justify-center items-center gap-3">
        <video class="border-5 rounded-xl border-green-500 video" id="preview"></video>
        <button class="bg-black py-2 cursor-pointer rounded-md text-neutral-50 w-full hover:bg-black/90"
            onclick="scanQRCode()">Scan QR
            Code</button>
        <form id="find_code" class="w-full mt-3">
            <div class="flex items-center justify-center gap-3">
                <input type="text"
                    class="block w-full rounded-md bg-neutral-50 px-3 py-1.5
                    text-base text-neutral-900 outline-1 -outline-offset-1
                    outline-gray-300 placeholder:text-gray-400 sm:text-sm/6 focus:outline-2 focus:-outline-offset-2 focus:outline-green-600"
                    name="code" placeholder="Input document tracking code" required>
                <button type="submit" id="find_code_button"
                    class="bg-blue-600 py-2 rounded-md text-neutral-50 w-30 cursor-pointer hover:bg-blue-500">Find
                    Code</button>
            </div>
        </form>
    </div>
</div>

<script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>
<script src="<?php echo $env_basePath; ?>assets/jquery/jquery-3.2.1.slim.min.js"></script>
<script src="<?php echo $env_basePath; ?>assets/jquery/jquery-3.6.4.min.js"></script>
<script>
    /* -------- QR‑scanner util -------- */
    let scanner; // Instascan.Scanner instance
    let cameras = []; // discovered cameras

    async function discoverCameras() {
        if (cameras.length) return cameras; // cached
        cameras = await Instascan.Camera.getCameras();
        if (!cameras.length) throw new Error('No cameras found');
        return cameras;
    }

    async function createScanner() {
        if (scanner) return scanner; // singleton
        scanner = new Instascan.Scanner({
            video: document.getElementById('preview')
        });
        scanner.addListener('scan', onQRScan);
        return scanner;
    }

    async function startScanner() {
        await Promise.all([discoverCameras(), createScanner()]);
        if (scanner.state?.startsWith('started')) { // already running
            console.log('Scanner already active');
            return;
        }
        const rearCam = cameras.find(c => c.name.toLowerCase().includes('back')) || cameras[0];
        await scanner.start(rearCam); // wait until fully started
        console.log('Scanner started');
    }

    async function stopScanner() {
        if (scanner?.state === 'started') {
            await scanner.stop();
            console.log('Scanner stopped');
        }
    }

    /* -------- QR‑code handler -------- */
    function onQRScan(content) {
        let url, code;
        try {
            url = new URL(content);
            code = url.searchParams.get('code');
            if (!code) throw new Error();
        } catch {
            return Swal.fire('Error', 'Failed to parse QR code content', 'error');
        }

        $('.loader-container').fadeIn();
        $.post(
            '../../controller/upload-docu-controller.php',
            $("#find_code").serialize() + `&action=find_code&code=${code}`,
            handleFindResponse,
            'json'
        ).fail(xhrAjaxError);
    }

    function handleFindResponse(resp) {
        $('.loader-container').fadeOut(500);

        if (resp.status === 'failed') {
            return Swal.fire('Failed!', resp.message, 'warning');
        }
        if (resp.status === 'error') {
            return Swal.fire('Error!', resp.message, 'error');
        }
        if (resp.status === 'success') {
            Swal.fire({
                title: 'QR Code Matched!',
                text: `Code: ${resp.code}`,
                icon: 'success',
                showCancelButton: true,
                confirmButtonText: 'Receive',
                cancelButtonText: 'View',
            }).then(result => {
                if (result.isConfirmed) receiveDocument(resp.code);
                else window.location.href = `track-document.php?code=${resp.code}`;
            });
        }
    }

    function receiveDocument(code) {
        $('.loader-container').fadeIn();
        const fd = new FormData();
        fd.append('action', 'receive_document_qrcode');
        fd.append('code', code);

        $.ajax({
            url: '../../controller/transfer-document-controller.php',
            type: 'POST',
            data: fd,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: handleReceiveResponse,
            error: xhrAjaxError
        });
    }

    function handleReceiveResponse(resp) {
        $('.loader-container').fadeOut(500);

        const msgTitle = resp.status === 'success' ? 'Success!' :
            (resp.status === 'failed' ? 'Something went wrong!' : 'Error!');
        const icon = resp.status === 'success' ? 'success' :
            (resp.status === 'failed' ? 'warning' : 'error');

        Swal.fire(msgTitle, resp.message, icon).then(() => {
            if (resp.status === 'success') window.location.href = 'received-documents.php';
            if (resp.status === 'error') location.reload();
        });
    }

    function xhrAjaxError(xhr) {
        $('.loader-container').fadeOut(500);
        Swal.fire(
            'Error!',
            `An error occurred while processing your request.\n${xhr.statusText}\n\n${JSON.stringify(xhr, null, 2)}`,
            'error'
        ).then(() => location.reload());
    }

    /* -------- Manual code‑search form -------- */
    $('#find_code_button').on('click', e => {
        const $form = $('#find_code');
        if (!$form[0].checkValidity()) return; // let native validation handle
        e.preventDefault();
        $('.loader-container').fadeIn();
        $.post(
            '../../controller/upload-docu-controller.php',
            $form.serialize() + '&action=find_code',
            handleFindResponse,
            'json'
        ).fail(xhrAjaxError);
    });

    /* -------- Lifecycle hooks -------- */
    document.addEventListener('DOMContentLoaded', startScanner);
    window.addEventListener('beforeunload', stopScanner);

    /* Expose a manual restart button (if you still want one) */
    function scanQRCode() {
        stopScanner().then(startScanner);
    }
</script>
