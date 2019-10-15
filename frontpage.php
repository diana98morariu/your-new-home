<?php
$sActive = 'Frontpage';
session_start();
if (empty($_SESSION)){
    require_once('top-not-signedin.php');
}else{
    require_once('top-signedin.php');
}
?>




<div class="wrap">
    <h1>Find Your New Home</h1>
    <form class="search" id="frmSearch">
        <input id="txtSearch" name="search" type="number" class="searchTerm" placeholder="search" maxlength="5">
        <button type="submit" class="searchButton" onclick="checkSearch()">
        <i class="fa fa-search"></i>
        </button>
    </form>
    <div id="results"></div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script>

    function checkSearch(){
        if($('#txtSearch').val().length < 2){
            $('#txtSearch').addClass('error-search')
        }
    }

    const txtSearch = document.querySelector('#txtSearch')
    const divResults = document.getElementById('results')
    txtSearch.addEventListener('input', function(){

        if($('#txtSearch').val().length == 0){
            $('#txtSearch').removeClass('error-search')
            $('#results').hide()
            return;
        }

        if($('#txtSearch').val().length < 2){
            $('#txtSearch').addClass('error-search')
            return;
        }

        $.ajax({
            url: "api-search.php",
            data: $('#frmSearch').serialize(),
            dataType: "JSON"
        }).done(function(matches){
            
           $('#results').empty()
           $(matches).each(function(index, zip){
           zip = zip.replace(/</g, '&lt;')
           zip = zip.replace(/>/g, '&gt;')
               let divZip = `<a href="properties.php?zipcode=${zip}">${zip}</a>`
               $('#results').append(divZip)

           })

       
        }).fail(function(){
            //console.log('error-search')
        })


        if(txtSearch.value.length == 0){
            divResults.style.display = 'none'
        } else {
            divResults.style.display ='block'
        }
    })

</script>

<?php
require_once(__DIR__.'/bottom.php');
?>