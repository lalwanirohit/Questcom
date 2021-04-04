<?php $paymentMethods = $this->getPaymentMethods();?>
<?php $shippingMethods = $this->getShippingMethods();?>
<?php $billingAddress = $this->getBillingAddress();?>
<?php $shippingAddress = $this->getShippingAddress();?>
<?php $cart = $this->getCart();?>

<div class="container">
<h1>Checkout Page</h1>
<hr>
    <div class="row">
        <div class="col-md-10">
            <form action="" id="checkoutForm" method="POST" enctype="multipart/form-data" novalidate>
                <table>
                    <thead class="thead-dark">
                        <tr>
                            <th colspan="2"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <table>
                                    <thead class="thead-dark">
                                        <tr>
                                            <th colspan="2" scope="col">Billing Address</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td width="150px">First Name</td>
                                            <td width="300px"><input name="billing1[firstName]" type="text" class="disable1 form-control" id="firstName" value="<?php echo $billingAddress->firstName ?>"></td>
                                        </tr>
                                        <tr>
                                            <td>Last Name</td>
                                            <td><input name="billing1[lastName]" class="disable1 form-control" id="lastName" value="<?php echo $billingAddress->lastName ?>" type="text"></td>
                                        </tr>
                                        <tr>
                                            <td>Address</td>
                                            <td><input name="billing[address]" type="text" class="disable1 form-control" id="address" value="<?php echo $billingAddress->address ?>"></td>
                                            <!-- <td><textarea name="billing[address]" class="disable1" id="address"><?php //echo $billingAddress->address ?></textarea></td> -->
                                        </tr>
                                        <tr>
                                            <td>City</td>
                                            <td><input name="billing[city]" class="disable1 form-control" id="city" value="<?php echo $billingAddress->city ?>" type="text"></td>
                                        </tr>
                                        <tr>
                                            <td>State</td>
                                            <td><input name="billing[state]" class="disable1 form-control" id="state" value="<?php echo $billingAddress->state ?>" type="text"></td>
                                        </tr>
                                        <tr>
                                            <td>Country</td>
                                            <td><input name="billing[country]" class="disable1 form-control" id="country" value="<?php echo $billingAddress->country ?>" type="text"></td>
                                        </tr>
                                        <tr>
                                            <td>ZipCode</td>
                                            <td><input name="billing[zipCode]" class="disable1 form-control" id="zipCode" value="<?php echo $billingAddress->zipcode ?>" type="text"></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <a onclick="object.setForm('#checkoutForm').setUrl('<?php echo $this->getUrl()->getUrl('saveBilling', 'admin_cart_checkout') ?>').load()" class="btn btn-warning" href="javascript:void(0)">Save</a>
                                            </td>
                                            <td>
                                                <input class="ml-auto" name="bookAddressBilling" value="1" type="checkbox">
                                                <label for="save">save to address book</label>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                            <td width="200px"></td>
                            <td>
                                <table>
                                    <thead class="thead-dark">
                                        <tr>
                                            <th colspan="2" scope="col">Shipping Address</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td width="150px">Same as Billing</td>
                                            <td width="300px"><input value="1" name="sameAsBilling" type="checkbox"></td>
                                        </tr>
                                        <tr>
                                            <td>First Name</td>
                                            <td><input name="shipping1[firstName]" class="disable form-control" id="firstName" value="<?php echo $shippingAddress->firstName ?>" type="text"></td>
                                        </tr>
                                        <tr>
                                            <td>Last Name</td>
                                            <td><input name="shipping1[lastName]" class="disable form-control" id="lastName" value="<?php echo $shippingAddress->lastName ?>" type="text"></td>
                                        </tr>
                                        <tr>
                                            <td>Address</td>
                                            <td><input name="shipping[address]" type="text" class="disable form-control" id="address" value="<?php echo $shippingAddress->address ?>"></td>
                                        </tr>
                                        <tr>
                                            <td>City</td>
                                            <td><input name="shipping[city]" class="disable form-control" id="city" value="<?php echo $shippingAddress->city ?>" type="text"></td>
                                        </tr>
                                        <tr>
                                            <td>State</td>
                                            <td><input name="shipping[state]" class="disable form-control" id="state" value="<?php echo $shippingAddress->state ?>" type="text"></td>
                                        </tr>
                                        <tr>
                                            <td>Country</td>
                                            <td><input name="shipping[country]" class="disable form-control" id="country" value="<?php echo $shippingAddress->country ?>" type="text"></td>
                                        </tr>
                                        <tr>
                                            <td>ZipCode</td>
                                            <td><input name="shipping[zipcode]" class="disable form-control" id="zipcode" value="<?php echo $shippingAddress->zipcode ?>" type="text"></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <a onclick="object.setForm('#checkoutForm').setUrl('<?php echo $this->getUrl()->getUrl('saveShipping', 'admin_cart_checkOut') ?>').load()" class="btn btn-warning" href="javascript:void(0)">Save</a>
                                            </td>
                                            <td>
                                                <input class="ml-auto" name="bookAddressShipping" value="1" type="checkbox">
                                                <label for="save">save to address book</label>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <table>
                                    <thead class="thead-dark">
                                        <tr>
                                            <th colspan="2" scope="col">Payment Method</th>
                                        </tr>
                                        <tr>
                                            <td><b>Select</b></td>
                                            <td><b>Name</b></td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!$paymentMethods): ?>
                                            <tr>
                                                <td colspan="2">No Payment Method Available</td>
                                            </tr>
                                        <?php else: ?>
                                            <?php foreach ($paymentMethods->getData() as $paymentMethod): ?>
                                                <tr>
                                                    <td><input name="paymentMethod" type="radio" value="<?php echo $paymentMethod->methodId ?>" <?php if ($cart->paymentMethodId == $paymentMethod->methodId): ?> checked <?php endif;?>></td>
                                                    <td><?php echo $paymentMethod->name ?></td>
                                                </tr>
                                            <?php endforeach;?>
                                        <?php endif;?>
                                        <tr>
                                            <td colspan="2">
                                                <a onclick="object.setForm('#checkoutForm').setUrl('<?php echo $this->getUrl()->getUrl('savePaymentMethod', 'admin_cart_checkOut') ?>').load()" class="btn btn-warning" href="javascript:void(0)">Save</a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                            <td>
                                <table>
                                    <thead class="thead-dark">
                                        <tr>
                                            <th colspan="3" scope="col">Shipping Method</th>
                                        </tr>
                                        <tr>
                                            <td><b>Select</b></td>
                                            <td><b>Name</b></td>
                                            <td><b>Amount</b></td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!$shippingMethods): ?>
                                            <tr>
                                                <td colspan="2">No Payment Method Available</td>
                                            </tr>
                                        <?php else: ?>
                                            <?php foreach ($shippingMethods->getData() as $shippingMethod): ?>
                                                <tr>
                                                    <td><input name="shippingMethod" type="radio" value="<?php echo $shippingMethod->methodId ?>" <?php if ($cart->shippingMethodId == $shippingMethod->methodId): ?> checked <?php endif;?>></td>
                                                    <td><?php echo $shippingMethod->name ?></td>
                                                    <td><?php echo $shippingMethod->amount ?></td>
                                                </tr>
                                            <?php endforeach;?>
                                        <?php endif;?>
                                        <tr>
                                            <td colspan="3">
                                                <a onclick="object.setForm('#checkoutForm').setUrl('<?php echo $this->getUrl()->getUrl('saveShippingMethod', 'admin_cart_checkOut') ?>').load()" class="btn btn-warning" href="javascript:void(0)">Save</a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <table>
                                    <thead class="thead-dark">
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><b>Base Total</b></td>
                                            <td><?php echo $this->getBaseTotal()[0]; ?></td>
                                        </tr>
                                        <tr>
                                            <td><b>Total Dsicount</b></td>
                                            <td><?php echo $this->getBaseTotal()[1]; ?></td>
                                        </tr>
                                        <tr>
                                            <td><b>Shipping Charges</b></td>
                                            <td><?php echo $this->getShippingCharges(); ?></td>
                                        </tr>
                                        <tr>
                                            <td><b>Grand Total</b></td>
                                            <td><?php echo $this->getGrandTotal(); ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript">
    function function1() {
        var elements = document.getElementsByClassName('disable');
        $(elements).each(function(i, element) {
            if (element.disabled) {
                // element.value = document.getElementById(element.id).value;
                element.disabled = false;
            } else {
                // element.value = document.getElementById(element.id).value;
                element.disabled = true;
            }
        })
    };
</script>