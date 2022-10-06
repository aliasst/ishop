<?php
/** @var $page array */
?>
<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-light p-2">
            <li class="breadcrumb-item"><a href="<?php echo base_url();?>"><i class="fas fa-home"></i></a></li>
            <li class="breadcrumb-item"><?php echo $page['title'];?></li>
        </ol>
    </nav>
</div>

<div class="container py-3">
    <div class="row">

        <div class="col-lg-12 category-content">
            <h3 class="section-title"><?php echo $page['title'];?></h3>



                <div class="row">
                    <?php echo $page['content'];?>
                </div>








        </div>

    </div>
</div>

