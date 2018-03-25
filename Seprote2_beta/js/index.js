$(document).ready(() => {
    async function fetchDepts() {
        var fetched = null;
        await $.ajax({
            url: 'php/fetchDepartements.php',
            success(data) { fetched = data }
        });
        return fetched;
    }
    async function fetchProgs() {
        var fetched = null;
        await $.ajax({
            url: 'php/fetchProgrammes.php',
            success(data) { fetched = data }
        });
        return fetched;
    }

    // Fetch depts and progs
    fetchDepts().then(data=>{
        document.querySelector('.selectDep').innerHTML = data;
        fetchProgs().then(data=>{
            document.querySelector('.selectProg').innerHTML += data;
        });
    });

    // Event Listeners
    document.querySelector('.selectDep').addEventListener('change', evt=>{
        $.ajax({
            url: 'php/setDepartement.php',
            method: 'get',
            data: {departement:evt.target.value}
        });
    });
    document.querySelector('.selectProg').addEventListener('change', evt=>{
        window.dispatchEvent(new CustomEvent("Chart Update", {
            detail: { program: evt.target.value }
        }));
    });
});
