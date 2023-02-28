

<?php 

if($this->session->flashdata('error')){
	echo '<div class="alert alert-danger fade in alert-dismissable" ><strong>Error! </strong>';

	foreach ($this->session->flashdata('error') as $key => $value) {
		echo $value.'<br />';
	}

	echo '</div>';
}
