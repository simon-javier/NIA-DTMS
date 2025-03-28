<style>
    :root {
    --primary-color: #069734;
    --lighter-primary-color: #07b940;
    --white-color: #FFFFFF;
    --black-color: #181818;
    --bold: 600;
    --transition: all 0.5s ease;
    --box-shadow: 0 0.1rem 0.8rem rgba(0, 0, 0, 0.2);
    }
    ::-webkit-scrollbar {
        width: 4px;
        height: 4px;
    }

    ::-webkit-scrollbar-thumb {
        background-color: #009933; 
        border-radius: 6px;
    }
    .table-container{
        padding: 2.5rem;
        background-color: #fff;
        box-shadow: var(--box-shadow);
    }
    .dataTables_wrapper .dataTables_filter input {
        border: 2px solid var(--primary-color) !important;
        border-radius: 10px;
        padding: 5px;
        background-color: transparent;
        color: inherit;
        margin-left: 3px;
        
    }
    .dataTables_wrapper .dataTables_filter input:active {
        border: 1px solid var(--primary-color) !important;
        border-radius: 10px;
        padding: 5px;
    }
    #example_wrapper{
        overflow-x: scroll;
    }
    .main-content{
        position: relative;
        background-color: white;
        top: 0;
        max-height: 90vh;
        overflow-y: scroll;
        left: 90px;
        transition: var(--transition);
        width: calc(100% - 90px);
        padding: 1rem;

    }
    .form-control{
        border: 2px solid #009933;
        border-radius: 10px;
    }
</style>
