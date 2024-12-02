<ul class="sidebar-nav" id="sidebar-nav">
<?php 
    if($app->data->sidebar){
        foreach($app->data->sidebar as $key => $value){
            if(count($value->sub)){
                ?>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-target="#<?php print_r($key); ?>-nav-custom" data-bs-toggle="collapse" href="#">
                            <i class="bi <?php print_r($value->icon); ?>"></i>
                            <span><?php print_r($value->name); ?></span>
                        </a>
                        <ul id="<?php print_r($key); ?>-nav-custom" class="nav-content collapse" data-bs-parent="#sidebar-nav">
                            <?php 
                                foreach ($value->sub as $skey => $lv){
                                    ?>
                                    <li>
                                        <a href="<?php print_r($lv->url); ?>" class="sidebar-data">
                                            <i class="bi bi-circle"></i><span><?php print_r($lv->name); ?></span>
                                            </a>
                                        </li>
                                    <?php
                                }
                            ?>
                        </ul>
                    </li>
                <?php
            }else{
                ?>
                    <li class="nav-item">
                        <a class="nav-link collapsed sidebar-data" href="<?php print_r($value->url); ?>">
                            <i class="bi <?php print_r($value->icon); ?>"></i>
                            <span><?php print_r($value->name); ?></span>
                        </a>
                    </li>
                <?php
            }
        }
    }
?>
</ul>