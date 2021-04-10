    <nav class="navbar navbar-expand-lg navbar-light sticky-top" style="background: linear-gradient(to right, #87dae2 24%, #a1e5d0 62%);">
        <div class="container-fluid">
            <a class="navbar-brand" href="http://localhost/projects/questecom/"><span>QUESTECOM</span></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">

                <div class="navbar-nav ml-auto">

                    <a class="nav-link active" href="http://localhost/projects/questecom/">Home</a>
                    <a class="nav-link active" href="javascript:void(0)" onclick="object.setUrl('<?php echo $this->getUrl()->getUrl('show', 'admin_brand') ?>').resetParams().load()">Brand</a>
                    <a class="nav-link active" href="javascript:void(0)" onclick="object.setUrl('<?php echo $this->getUrl()->getUrl('show', 'admin_category') ?>').resetParams().load()">Category</a>
                    <a class="nav-link active" href="javascript:void(0)" onclick="object.setUrl('<?php echo $this->getUrl()->getUrl('show', 'admin_product') ?>').resetParams().load()">Product</a>
                    <a class="nav-link active" href="javascript:void(0)" onclick="object.setUrl('<?php echo $this->getUrl()->getUrl('show', 'admin_attribute') ?>').resetParams().load()">Attribute</a>
                    <a class="nav-link active" href="javascript:void(0)" onclick="object.setUrl('<?php echo $this->getUrl()->getUrl('show', 'admin_customer') ?>').resetParams().load()">Customer</a>
                    <a class="nav-link active" href="javascript:void(0)" onclick="object.setUrl('<?php echo $this->getUrl()->getUrl('show', 'admin_customer_group') ?>').resetParams().load()">Customer Group</a>
                    <a class="nav-link active" href="javascript:void(0)" onclick="object.setUrl('<?php echo $this->getUrl()->getUrl('show', 'admin_cms') ?>').resetParams().load()">Cms</a>
                    <a class="nav-link active" href="javascript:void(0)" onclick="object.setUrl('<?php echo $this->getUrl()->getUrl('show', 'admin_admin') ?>').resetParams().load()">Admin</a>
                    <a class="nav-link active" href="javascript:void(0)" onclick="object.setUrl('<?php echo $this->getUrl()->getUrl('show', 'admin_payment') ?>').resetParams().load()">Payment</a>
                    <a class="nav-link active" href="javascript:void(0)" onclick="object.setUrl('<?php echo $this->getUrl()->getUrl('show', 'admin_shipping') ?>').resetParams().load()">Shipment</a>
                    <a class="nav-link active" href="javascript:void(0)" onclick="object.setUrl('<?php echo $this->getUrl()->getUrl('grid', 'admin_cart') ?>').resetParams().load()">Cart</a>

                </div>

            </div>
        </div>
    </nav>
    <br><br>
