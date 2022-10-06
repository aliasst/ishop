<?php
/** @var $this \wfm\View */
/** @var $category array */
/** @var $products array */
/** @var $total int */
/** @var $pagination object */
?>
<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-light p-2">
            <li class="breadcrumb-item"><a href="<?php echo base_url();?>"><i class="fas fa-home"></i></a></li>
            <li class="breadcrumb-item"><?php __('wishlist_index_title');?></li>
        </ol>
    </nav>
</div>

<div class="container py-3">
    <div class="row">

        <div class="col-lg-12 category-content">
            <h3 class="section-title"><?php __('wishlist_index_title');?></h3>


            <?php if (!empty($products)): ?>
                <div class="row">
                    <?php $this->getPart('parts/products_loop', compact('products')); ?>
                </div>



            <?php else: ?>
                <p><?php __('category_view_no_products'); ?></p>
            <?php endif; ?>




        </div>

    </div>
</div>

