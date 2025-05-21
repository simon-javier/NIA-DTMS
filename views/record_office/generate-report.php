<?php require 'template/top-template.php'; ?>

<div class="border-b border-gray-900/10 p-12 rounded-md bg-neutral-50 w-[95%] self-center my-10">
    <h3 class="text-2xl uppercase text-green-800 font-bold">Generate Reports</h3>
    <form id='generate_reports_form' action="export-pdf-template.php" method="get" autocomplete="off"
        enctype="multipart/form-data">
        <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
            <div class="sm:col-span-full">
                <label for="doc_type" class="block text-sm/6 font-medium text-neutral-900">Document Type</label>
                <div class="mt-2 grid grid-cols-1">
                    <select id="doc_type" name="doc_type"
                        class="col-start-1 row-start-1 w-full appearance-none rounded-md bg-white py-1.5 pr-8 pl-3 text-base text-neutral-900 outline-1 -outline-offset-1 outline-gray-300 focus:outline-2 focus:-outline-offset-2 focus:outline-green-600 sm:text-sm/6">
                        <option value="Select" selected>Select</option>
                        <option value="complete">Complete Documents</option>
                        <option value="decline">Incomplete Documents</option>
                        <option value="ongoing">Ongoing Documents</option>
                    </select>
                    <svg class="pointer-events-none col-start-1 row-start-1 mr-2 size-5 self-center justify-self-end text-gray-500 sm:size-4"
                        viewBox="0 0 16 16" fill="currentColor" aria-hidden="true" data-slot="icon">
                        <path fill-rule="evenodd"
                            d="M4.22 6.22a.75.75 0 0 1 1.06 0L8 8.94l2.72-2.72a.75.75 0 1 1 1.06 1.06l-3.25 3.25a.75.75 0 0 1-1.06 0L4.22 7.28a.75.75 0 0 1 0-1.06Z"
                            clip-rule="evenodd" />
                    </svg>
                </div>
            </div>

            <div class="sm:col-span-3">
                <label for="sender" class="block text-sm/6 font-medium text-neutral-900">Date From:</label>
                <div class="mt-2">
                    <input type="date" name="from" id="from"
                        class="block w-full rounded-md bg-neutral-50 px-3 py-1.5 
                    text-base text-neutral-900 outline-1 -outline-offset-1
                    outline-gray-300 placeholder:text-gray-400 sm:text-sm/6 focus:outline-2 focus:-outline-offset-2 focus:outline-green-600">
                </div>
            </div>

            <div class="sm:col-span-3">
                <label for="receiver" class="block text-sm/6 font-medium text-neutral-900">Date To:</label>
                <div class="mt-2">
                    <input type="date" name="dateto" id="dateto"
                        class="block w-full rounded-md bg-neutral-50 px-3 py-1.5 
                    text-base text-neutral-900 outline-1 -outline-offset-1
                    outline-gray-300 placeholder:text-gray-400 sm:text-sm/6 focus:outline-2 focus:-outline-offset-2 focus:outline-green-600">
                </div>
            </div>

        </div>
        <div class="mt-6 flex items-center justify-end gap-x-6">
            <button type="reset"
                class="cursor-pointer text-sm/6 font-semibold text-gray-900 hover:text-gray-900/80">Clear</button>
            <button type="submit"
                class="cursor-pointer rounded-md disabled:bg-gray-500 disabled:cursor-default bg-green-600 px-3 py-2 text-sm font-semibold text-white shadow-xs hover:bg-green-800 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-green-600">Generate</button>
        </div>
    </form>
</div>
</main>
