<?php 
    if ($this->session->flashdata('message')) :
        echo $this->session->flashdata('message');
    endif;
?>