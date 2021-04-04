<div class="col-9 mx-auto fadeoutmsg">

    <?php if ($success = $this->getMessage()->getSuccess()) : $this->getMessage()->clearSuccess(); ?>
        <div class="alert alert-success" role="alert">
            <?= $success; ?>
        </div>
    <?php endif ?>
    <?php if ($failure = $this->getMessage()->getFailure()) : $this->getMessage()->clearFailure(); ?>
        <div class="alert alert-danger" role="alert">
            <?= $failure; ?>
        </div>
    <?php endif ?>

</div>

<script>
    $(".fadeoutmsg").fadeOut(4000);
</script>