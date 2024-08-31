window.addEventListener('DOMContentLoaded', async (event) => {
    // Simple-DataTables
    // https://github.com/fiduswriter/Simple-DataTables/wiki

    console.log('ola')
    let response = await fetch('http://127.0.0.1:8000/get-average')

    if (!response.ok) {
      throw new Error(`Response status: ${response.status}`);
    }

    const json = await response.json();

    const datatablesSimple = document.getElementById('datatablesSimple');
    if (datatablesSimple) {
        new newDataTable.DataTable(datatablesSimple);
        
    }
});
