<div class="w3-row">&nbsp;</div>
<?php foreach($addresses as $address) : ?>
<div class="w3-container">
    <?php 
        echo (
            $address->address_id 
            .": " . $address->line1 
            ."-". $address->line2 
            . " " . $address->city
            . " " . $address->state
            . " " . $address->zip
            . " | "
            . "<a href='/address/update/".$address->address_id ."'><i class=\"fa fa-pencil-square-o\" aria-hidden=\"true\"></i></a>"
            . " <a href='/address/delete/".$address->address_id ."'><i class=\"fa fa-trash-o\" aria-hidden=\"true\"></i></i></a>"
        ); 
    ?>
</div>
<?php endforeach; ?>