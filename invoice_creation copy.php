<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create New Invoice</title>
    <!-- Include your CSS files here -->
</head>
<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f9f9f9;
        margin: 0;
        padding: 20px;
    }

    h2 {
        color: #333;
        text-align: center;
    }

    form {
        background: #fff;
        padding: 20px;
        border-radius: 5px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .table {
        width: 100%;
        margin-bottom: 20px;
    }

    .table th,
    .table td {
        padding: 10px;
        text-align: left;
        border: 1px solid #ddd;
    }

    .table th {
        background-color: #f1f1f1;
    }

    .input-group {
        display: flex;
    }

    .input-group .input-group-addon {
        padding: 10px;
        background: #eee;
        border: 1px solid #ddd;
    }

    .input-group input {
        flex: 1;
        padding: 10px;
        border: 1px solid #ddd;
        border-left: none;
    }

    .btn {
        display: inline-block;
        padding: 10px 20px;
        color: #fff;
        background-color: #007bff;
        border: none;
        border-radius: 5px;
        text-decoration: none;
        cursor: pointer;
    }

    .btn:hover {
        background-color: #0056b3;
    }

    .btn-xs {
        padding: 5px 10px;
        font-size: 12px;
    }

    .btn-danger {
        background-color: #dc3545;
    }

    .btn-danger:hover {
        background-color: #c82333;
    }

    .btn-success {
        background-color: #28a745;
    }

    .btn-success:hover {
        background-color: #218838;
    }

    .alert {
        padding: 15px;
        background-color: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
        border-radius: 5px;
        margin-bottom: 20px;
    }

    .alert-success {
        background-color: #d4edda;
        color: #155724;
        border-color: #c3e6cb;
    }

    .alert .close {
        float: right;
        color: inherit;
        text-decoration: none;
        font-size: 20px;
        line-height: 1;
    }
</style>

<body>

    <h2>Create New <span class="invoice_type">Invoice</span></h2>

    <div id="response" class="alert alert-success" style="display:none;">
        <a href="#" class="close" data-dismiss="alert">&times;</a>
        <div class="message"></div>
    </div>

    <form method="post" id="create_invoice">
        <input type="hidden" name="action" value="create_invoice">

        <div class="row">
            <div class="col-xs-4"></div>
            <div class="col-xs-8 text-right">
                <div class="row">
                    <div class="col-xs-6">
                        <h2>Select Type:</h2>
                    </div>
                    <div class="col-xs-3">
                        <select name="invoice_type" id="invoice_type" class="form-control">
                            <option value="invoice" selected>Invoice</option>
                            <option value="quote">Quote</option>
                            <option value="receipt">Receipt</option>
                        </select>
                    </div>
                    <div class="col-xs-3">
                        <select name="invoice_status" id="invoice_status" class="form-control">
                            <option value="open" selected>Open</option>
                            <option value="paid">Paid</option>
                        </select>
                    </div>
                </div>
                <div class="col-xs-4 no-padding-right">
                    <div class="form-group">
                        <div class="input-group date" id="invoice_date">
                            <input type="text" class="form-control required" name="invoice_date" placeholder="Invoice Date" data-date-format="Y-m-d">
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-xs-4">
                    <div class="form-group">
                        <div class="input-group date" id="invoice_due_date">
                            <input type="text" class="form-control required" name="invoice_due_date" placeholder="Due Date" data-date-format="Y-m-d">
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="input-group col-xs-4 float-right">
                    <span class="input-group-addon">#INV</span>
                    <input type="text" name="invoice_id" id="invoice_id" class="form-control required" placeholder="Invoice Number" aria-describedby="sizing-addon1" value="">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="float-left">Customer Information</h4>
                        <a href="#" class="float-right select-customer"><b>OR</b> Select Existing Customer</a>
                        <div class="clear"></div>
                    </div>
                    <div class="panel-body form-group form-group-sm">
                        <div class="row">
                            <div class="col-xs-6">
                                <div class="form-group">
                                    <input type="text" class="form-control margin-bottom copy-input required" name="customer_name" id="customer_name" placeholder="Enter Name" tabindex="1">
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control margin-bottom copy-input required" name="customer_address_1" id="customer_address_1" placeholder="Address 1" tabindex="3">
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control margin-bottom copy-input required" name="customer_town" id="customer_town" placeholder="Town" tabindex="5">
                                </div>
                                <div class="form-group no-margin-bottom">
                                    <input type="text" class="form-control copy-input required" name="customer_postcode" id="customer_postcode" placeholder="Postcode" tabindex="7">
                                </div>
                            </div>
                            <div class="col-xs-6">
                                <div class="input-group float-right margin-bottom">
                                    <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                                    <input type="email" class="form-control copy-input required" name="customer_email" id="customer_email" placeholder="E-mail Address" aria-describedby="sizing-addon1" tabindex="2">
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control margin-bottom copy-input" name="customer_address_2" id="customer_address_2" placeholder="Address 2" tabindex="4">
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control margin-bottom copy-input required" name="customer_county" id="customer_county" placeholder="Country" tabindex="6">
                                </div>
                                <div class="form-group no-margin-bottom">
                                    <input type="text" class="form-control required" name="customer_phone" id="customer_phone" placeholder="Phone Number" tabindex="8">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xs-6 text-right">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4>Shipping Information</h4>
                    </div>
                    <div class="panel-body form-group form-group-sm">
                        <div class="row">
                            <div class="col-xs-6">
                                <div class="form-group">
                                    <input type="text" class="form-control margin-bottom required" name="customer_name_ship" id="customer_name_ship" placeholder="Enter Name" tabindex="9">
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control margin-bottom" name="customer_address_2_ship" id="customer_address_2_ship" placeholder="Address 2" tabindex="11">
                                </div>
                                <div class="form-group no-margin-bottom">
                                    <input type="text" class="form-control required" name="customer_county_ship" id="customer_county_ship" placeholder="Country" tabindex="13">
                                </div>
                            </div>
                            <div class="col-xs-6">
                                <div class="form-group">
                                    <input type="text" class="form-control margin-bottom required" name="customer_address_1_ship" id="customer_address_1_ship" placeholder="Address 1" tabindex="10">
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control margin-bottom required" name="customer_town_ship" id="customer_town_ship" placeholder="Town" tabindex="12">
                                </div>
                                <div class="form-group no-margin-bottom">
                                    <input type="text" class="form-control required" name="customer_postcode_ship" id="customer_postcode_ship" placeholder="Postcode" tabindex="14">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- / end client details section -->
        <table class="table table-bordered table-hover table-striped" id="invoice_table">
            <thead>
                <tr>
                    <th width="500">
                        <h4><a href="#" class="btn btn-success btn-xs add-row"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span></a> Product</h4>
                    </th>
                    <th>
                        <h4>Qty</h4>
                    </th>
                    <th>
                        <h4>Price</h4>
                    </th>
                    <th width="300">
                        <h4>Discount</h4>
                    </th>
                    <th>
                        <h4>Sub Total</h4>
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                         <br>
                        <div class="form-group form-group-sm no-margin-bottom">
                            <a href="#" class="btn btn-danger btn-xs delete-row"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a>
                            <input type="text" class="form-control form-group-sm item-input invoice_product" name="invoice_product[]" placeholder="Enter Product Name OR Description">
                            <p class="item-select">or <a href="#">select a product</a></p>
                        </div>
                    </td>
                    <td class="text-right">
                        <div class="form-group form-group-sm no-margin-bottom">
                            <input type="number" class="form-control invoice_product_qty calculate" name="invoice_product_qty[]" value="1">
                        </div>
                    </td>
                    <td class="text-right">
                        <div class="input-group input-group-sm no-margin-bottom">
                            <span class="input-group-addon">$</span>
                            <input type="number" class="form-control calculate invoice_product_price required" name="invoice_product_price[]" value="0.00">
                        </div>
                    </td>
                    <td class="text-right">
                        <div class="input-group input-group-sm no-margin-bottom">
                            <input type="number" class="form-control calculate invoice_product_discount" name="invoice_product_discount[]" value="0">
                            <span class="input-group-addon">%</span>
                        </div>
                    </td>
                    <td class="text-right">
                        <div class="input-group input-group-sm">
                            <span class="input-group-addon">$</span>
                            <input type="text" class="form-control calculate-sub" name="invoice_product_sub[]" value="0.00" disabled>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
        <div id="invoice_totals" class="padding-right row text-right">
            <div class="col-xs-6">
                <div class="col-xs-6 no-padding-right">
                    <h4>Discount:</h4>
                </div>
                <div class="col-xs-6">
                    <div class="input-group input-group-sm">
                        <input type="number" class="form-control calculate" name="invoice_discount" id="invoice_discount" value="0">
                        <span class="input-group-addon">%</span>
                    </div>
                </div>
                <div class="col-xs-6 no-padding-right">
                    <h4>Tax:</h4>
                </div>
                <div class="col-xs-6">
                    <div class="input-group input-group-sm">
                        <input type="number" class="form-control calculate" name="invoice_vat" id="invoice_vat" value="0">
                        <span class="input-group-addon">%</span>
                    </div>
                </div>
                <div class="col-xs-6 no-padding-right">
                    <h4>Shipping:</h4>
                </div>
                <div class="col-xs-6">
                    <div class="input-group input-group-sm">
                        <span class="input-group-addon">$</span>
                        <input type="number" class="form-control calculate" name="invoice_shipping" id="invoice_shipping" value="0.00">
                    </div>
                </div>
            </div>
            <div class="col-xs-6">
                <div class="col-xs-4 col-xs-offset-4 no-padding-right">
                    <h4>Total:</h4>
                </div>
                < class="col-xs-4">
                    <div class="input-group input-group-sm">
                        <span class="input-group-addon">$</span>
                        <input type="number" class="form-control" name="invoice_total" id="invoice_total" value="0.00" disabled>
                    </div>
                    <br>
                    <br>
            </div>
            <br>
        </div>
        </div>
        <br>
        <div class="clearfix"></div>
        <textarea class="form-control" name="invoice_notes" placeholder="Additional Notes..." rows="3"></textarea>
        <div class="row">
            <div class="col-xs-5">
                <a href="#" class="btn btn-success" id="create_invoice_confirm"><i class="fa fa-save"></i> Save Invoice</a>
            </div>
        </div>
    </form>
    <br>
    <!-- Include your JS files here -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const createInvoiceForm = document.getElementById("create_invoice");
            const invoiceTable = document.getElementById("invoice_table").querySelector("tbody");
            const addRowButton = document.querySelector(".add-row");
            const calculateElements = document.querySelectorAll(".calculate");

            function calculateTotals() {
                let subtotal = 0;
                invoiceTable.querySelectorAll("tr").forEach(row => {
                    const qty = parseFloat(row.querySelector(".invoice_product_qty").value) || 0;
                    const price = parseFloat(row.querySelector(".invoice_product_price").value) || 0;
                    const discount = parseFloat(row.querySelector(".invoice_product_discount").value) || 0;
                    const subTotalCell = row.querySelector(".calculate-sub");
                    let subTotal = qty * price * (1 - discount / 100);
                    subTotalCell.value = subTotal.toFixed(2);
                    subtotal += subTotal;
                });

                const discountTotal = subtotal * (parseFloat(document.getElementById("invoice_discount").value) || 0) / 100;
                const taxTotal = subtotal * (parseFloat(document.getElementById("invoice_vat").value) || 0) / 100;
                const shippingTotal = parseFloat(document.getElementById("invoice_shipping").value) || 0;
                const total = subtotal - discountTotal + taxTotal + shippingTotal;
                document.getElementById("invoice_total").value = total.toFixed(2);
            }

            addRowButton.addEventListener("click", function(e) {
                e.preventDefault();
                const newRow = document.createElement("tr");
                newRow.innerHTML = `
            <td>
                <div class="form-group form-group-sm no-margin-bottom">
                    <a href="#" class="btn btn-danger btn-xs delete-row"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a>
                    <input type="text" class="form-control form-group-sm item-input invoice_product" name="invoice_product[]" placeholder="Enter Product Name OR Description">
                    <p class="item-select">or <a href="#">select a product</a></p>
                </div>
            </td>
            <td class="text-right">
                <div class="form-group form-group-sm no-margin-bottom">
                    <input type="number" class="form-control invoice_product_qty calculate" name="invoice_product_qty[]" value="1">
                </div>
            </td>
            <td class="text-right">
                <div class="input-group input-group-sm no-margin-bottom">
                    <span class="input-group-addon">$</span>
                    <input type="number" class="form-control calculate invoice_product_price required" name="invoice_product_price[]" value="0.00">
                </div>
            </td>
            <td class="text-right">
                <div class="input-group input-group-sm no-margin-bottom">
                    <input type="number" class="form-control calculate invoice_product_discount" name="invoice_product_discount[]" value="0">
                    <span class="input-group-addon">%</span>
                </div>
            </td>
            <td class="text-right">
                <div class="input-group input-group-sm">
                    <span class="input-group-addon">$</span>
                    <input type="text" class="form-control calculate-sub" name="invoice_product_sub[]" value="0.00" disabled>
                </div>
            </td>
        `;
                invoiceTable.appendChild(newRow);
            });

            invoiceTable.addEventListener("click", function(e) {
                if (e.target.classList.contains("delete-row")) {
                    e.preventDefault();
                    e.target.closest("tr").remove();
                    calculateTotals();
                }
            });

            calculateElements.forEach(element => {
                element.addEventListener("input", calculateTotals);
            });

            document.getElementById("create_invoice_confirm").addEventListener("click", function(e) {
                e.preventDefault();
                alert("Invoice Saved!"); // Implement the actual saving functionality
            });

            calculateTotals();
        });
    </script>
</body>

</html>