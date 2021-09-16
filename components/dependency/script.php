<!-- JavaScript -->
<script type="text/javascript">
    funApply = (month, pos) => {
        let year = document.getElementById('yearNumber').value 
        document.getElementById('monthNumber').innerHTML = `${month}`   
        window.location.href = `?month=${pos}&year=${year}`
    }
    
    const table = document.getElementById('table')
</script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.6.0/mdb.min.js"></script>