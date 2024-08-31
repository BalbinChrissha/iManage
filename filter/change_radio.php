<?php
require "../functions.php";
include('../inc/header.php');

?>
<style>
    body {
        font-family: 'Poppins';
        width: 100%;
        height: auto;
        background-image: url('images/banner.jpg');
        background-attachment: fixed;
        background-size: cover;
    }

    a {
        text-decoration: none;
    }
</style>



<?php


// Retrieve the button value from the request
$dropdown = $_POST['dropdown'];
if ($dropdown == "Equipment") {
    $html = '<label for="">State</label><br>';
    $html .= '<select id="statefil" class="form-select mb-3" name="classification" required>';
    $html .= '<option value="Available">Available</option>';
    $html .= '<option value="Unavailable - Decomissioned">Unavailable - Decomissioned</option>';
    $html .= '<option value="Unavailable - In repair">Unavailable - In repair</option>';
    $html .= '</select>';
} else {
    //     $html = '<label for="">State</label><br>';
    //     $html .= '<input class="form-check-input" type="radio" value="Available" name="state"> Available &nbsp; &nbsp;';
    //     $html .= '<input class="form-check-input" type="radio" value="Consumed" name="state"> Consumed &nbsp; &nbsp;';
    //     $html .= '<input class="form-check-input" type="radio" value="Expired" name="state"> Expired &nbsp; &nbsp;';
    $html = '<label for="">State</label><br>';
    $html .= '<select id="statefil" class="form-select mb-3" name="classification" required>';
    $html .= '<option value="Available">Available</option>';
    $html .= '<option value="Consumed">Consumed</option>';
    $html .= '<option value="Expired">Expired</option>';
    $html .= '</select>';
}

echo $html;

?>