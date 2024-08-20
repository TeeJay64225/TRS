<?php
session_start();
include('db.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Handling the receipt creation
if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['action'] == 'add_client') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $address1 = $_POST['address1'];
    $address2 = $_POST['address2'];
    $town = $_POST['town'];
    $country = $_POST['country'];
    $postcode = $_POST['postcode'];
    $phone = $_POST['phone'];

    // Insert client data
    $sql = "INSERT INTO clients (name, email, address1, address2, town, country, postcode, phone) 
            VALUES ('$name', '$email', '$address1', '$address2', '$town', '$country', '$postcode', '$phone')";

    if ($conn->query($sql) === TRUE) {
        echo "New client added successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Start Transaction
    $conn->begin_transaction();

    try {
        // Insert into receipts table
        $stmt = $conn->prepare("INSERT INTO receipts (client_id, receipt_date, due_date, total, tax, grand_total, payment_method, message) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("isssssss", $client_id, $receipt_date, $due_date, $total, $tax, $grand_total, $payment_method, $message);

        $client_id = $_POST['client_id'];
        $receipt_date = $_POST['date'];
        $due_date = $_POST['due_date'];
        $total = $_POST['total'];
        $tax = $_POST['tax'];
        $grand_total = $_POST['grand_total'];
        $payment_method = $_POST['payment_method'];
        $message = $_POST['custom_email'];

        $stmt->execute();
        $receipt_id = $stmt->insert_id;

        // Insert into receipt_items table
        foreach ($_POST['description'] as $index => $description) {
            $product_id = $_POST['product_id'][$index];
            $quantity = $_POST['quantity'][$index];
            $discount = $_POST['discount'][$index];
            $subtotal = $_POST['subtotal'][$index];

            $stmt = $conn->prepare("INSERT INTO receipt_items (receipt_id, product_id, quantity, discount, subtotal) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("iiidd", $receipt_id, $product_id, $quantity, $discount, $subtotal);
            $stmt->execute();
        }

        // Commit transaction
        $conn->commit();

        // Redirect to a success page
        header("Location: receipt_creation.php");
        exit();
    } catch (Exception $e) {
        // Rollback transaction if something goes wrong
        $conn->rollback();
        echo "Failed to create receipt: " . $e->getMessage();
    }
}
?>

<?php
// Include the database connection
include 'db.php';

// Fetch the last client_id from the database
$sql = "SELECT MAX(client_id) AS max_id FROM receipts";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $next_client_id = $row['max_id'] + 1;
} else {
    // If no clients exist, start with ID 1
    $next_client_id = 1;
}

$conn->close();
?>

<?php
function generateReceiptNumber()
{
    $prefix = "REC-";
    $randomNumber = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT); // Generates a random 6-digit number
    return $prefix . $randomNumber;
}

$randomReceiptNumber = generateReceiptNumber();
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt Management</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="invoice_creation.css">
    <script src="https://kit.fontawesome.com/aa7454d09f.js" crossorigin="anonymous"></script>
</head>
<style>
    .navLink a {
        color: var(--primaryColor);
        /* Set the text color to black */
        text-decoration: none;
        /* Remove the underline from the links */
    }

    .navLink a:hover {
        color: var(--primaryColor);
        /* Optional: Darker color on hover */
    }
</style>

<body>
    <div id="dashboard">
        <div>
            <div class="toggleMenu" id="toggleMenu">
                <i class="fa-solid fa-arrow-right icon toggelMenuIcon" id="toggelMenuIcon"></i>
            </div>
            <div class="sideNav" id="sideNav">
                <div id="topNav">
                    <div id="logo">
                        <span class="logoPic">TRS</span>
                        <h1 class="logoName">Truck Record Services</h1>
                    </div>
                    <p class="navSectionName">Main Menu</p>
                    <ul class="nav">
                        <li class="navLink">
                            <i class="fa-solid fa-gauge icon"></i>
                            <a href="user_landing_page.php"> Home
                            </a>
                        </li>
                        <li class="navLink ">
                            <i class="fa-solid fa-plus icon"></i>
                            <a href="invoice_creation.php">Invoice Creation</a>
                        </li>
                        <li class="navLink activeNavLink">
                            <i class="fa-solid fa-plus icon"></i>
                            <a href="receipt_management.php">Receipt Creation</a>
                        </li>
                        <li class="navLink " id="invoiceCreationNav">
                            <i class="fa-solid fa-mug-hot"></i>
                            <a href="all_invoice.php">All Invoice</a>
                        </li>
                        <li class="navLink" id="invoiceCreationNav">
                            <i class="fa-solid fa-mug-hot"></i>
                            <a href="all_receipt.php">All Receipt</a>
                        </li>
                        <li class="navLink">
                            <i class="fa-solid fa-credit-card icon"></i>
                            <a href="all_client.php">All clients</a>
                        </li>
                        <li class="navLink">
                            <i class="fa-solid fa-address-book icon"></i>
                            <a href="client_management.php">Add Client </a>
                        </li>

                    </ul>
                    <p class="navSectionName">Others</p>
                    <ul class="nav">
                        <li class="navLink">
                            <i class="fa-solid fa-gear icon"></i>
                            Setting
                        </li>
                        <li class="navLink">
                            <i class="fa-solid fa-headset icon"></i>
                            Help Center
                        </li>
                        <li class="navLink" id="logoutNav">
                            <i class="fa-solid fa-right-from-bracket"></i>
                            <a href="logout.php">Logout</a>
                        </li>
                    </ul>
                </div>

                <div id="bottomNav">
                    <h3 class="copyright">&copy; Truck Receipt Service (TRS), 2024</h3>
                    <p class="copyDesc">Digital payment platform is a solution for all types of service.</p>
                </div>

            </div>
        </div>
        <main id="main">
            <header>

                <div class="toggleMenu" id="toggleMenu">
                    <i class="fa-solid fa-arrow-right icon toggelMenuIcon" id="toggelMenuIcon"></i>
                </div>
                <div class="headlineContainer">
                    <h1 class="headline">Welcome to TRS</h1>
                    <p class="subheadline">
                        Hi, User. Welcome Back
                    </p>
                </div>

                <div class="profileContainer">
                    <div class="iconContainer moonIcon" id="toggleTheme">
                        <i class="fa-solid fa-moon" id="toggleThemeIcon"></i>
                    </div>
                    <div class="iconContainer">
                        <i class="fa-solid fa-bell notification"></i>
                    </div>
                    <div class="profilePic">
                        <img src="./img/profile.jpg" alt="">
                    </div>
                </div>
            </header>

            <br>
            <br>
            <div class="headlineContainer">
                <h1 class="headline">Receipt</h1>
            </div>
            <form id="receiptForm" action="receipt_management.php" method="POST">
                <div class="form-group float-right">
                    <div class="input-group col-xs-4">
                        <span class="input-group-addon">#Receipt Number</span>
                        <input type="text" name="receipt_id" id="receipt_id" class="form-control required" placeholder="Receipt Number" value="<?php echo $randomReceiptNumber; ?>" required readonly>
                    </div>
                </div>

                <section class="receipt-form">
                    <div class="form-container">
                        <div class="form-section">
                            <h2>Customer Information</h2>
                            <div class="form-group">
                                <label for="client-id">Client ID</label>
                                <input type="number" id="client-id" name="client_id" value="<?php echo isset($next_client_id) ? number_format($next_client_id) : ''; ?>" readonly required>
                            </div>
                            <div class="form-group">
                                <label for="customer-name">Customer Name</label>
                                <input type="text" id="customer-name" placeholder="Enter Name">
                            </div>
                            <div class="form-group">
                                <label for="customer-email">E-mail Address</label>
                                <input type="email" id="customer-email" placeholder="E-mail Address">
                            </div>
                            <div class="form-group">
                                <label for="customer-address1">Address 1</label>
                                <input type="text" id="customer-address1" placeholder="Address 1">
                            </div>
                            <div class="form-group">
                                <label for="customer-address2">Address 2</label>
                                <input type="text" id="customer-address2" placeholder="Address 2">
                            </div>

                        </div>

                        <div class="form-section1">
                            <div class="form-group">
                                <label for="due_date">Receipt Date:</label>
                                <input type="date" id="due_date" name="due_date" class="form-control required" required>
                            </div>
                            <div class="form-group">
                                <label for="due_date">Due Date:</label>
                                <input type="date" id="due_date" name="due_date" class="form-control required" required>
                            </div>
                            <div class="form-group">
                                <label for="customer-town">Town</label>
                                <input type="text" id="customer-town" placeholder="Town">
                            </div>
                            <div class="form-group">
                                <label for="customer-country">Country</label>
                                <input type="text" id="customer-country" placeholder="Country">
                            </div>
                            <div class="form-group">
                                <label for="customer-postcode">Postcode</label>
                                <input type="text" id="customer-postcode" placeholder="Postcode">
                            </div>
                            <div class="form-group">
                                <label for="customer-phone">Phone Number</label>
                                <input type="text" id="customer-phone" placeholder="Phone Number">
                            </div>
                        </div>
                    </div>
                </section>

                <section class="analytics">
                    <div class="analyticsCard">
                        <div>
                            <h2>Receipt Tracking Service</h2>
                            <br>

                            <table class="receipt-table table table-bordered table-hover table-striped" id="receiptTable">
                                <thead>
                                    <tr>
                                        <th width="500">
                                            <h4><a href="#" class="btn btn-success btn-xs addRow"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span></a> Product</h4>
                                        </th>
                                        <th width="300">
                                            <h4>Qty</h4>
                                        </th>
                                        <th width="300">
                                            <h4>Price</h4>
                                        </th>
                                        <th width="300">
                                            <h4>Discount</h4>
                                        </th>
                                        <th width="300">
                                            <h4>Sub Total</h4>
                                        </th>
                                        <th width="200">
                                            <h4>Remove</h4>
                                        </th>
                                        <th width="200">
                                            <h4>Add</h4>
                                        </th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <tr>
                                        <td><input type="text" name="product[]" class="form-control product"></td>
                                        <td><input type="text" name="qty[]" class="form-control qty"></td>
                                        <td><input type="text" name="price[]" class="form-control price"></td>
                                        <td><input type="text" name="discount[]" class="form-control discount"></td>
                                        <td><input type="text" name="amount[]" class="form-control amount"></td>
                                        <td><a href="#" class="btn btn-danger btn-xs remove"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span>Remove</a></td>
                                        <td><a href="#" class="btn btn-success btn-xs addRow"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span>Add</a></td>
                                    </tr>
                                </tbody>

                                <tfoot>
                                    <tr>
                                        <td style="border: none;"></td>
                                        <td style="border: none;"></td>
                                        <td style="border: none;"></td>
                                        <td>
                                            <h3>Total</h3>
                                        </td>
                                        <td><input type="text" name="total" class="form-control total" readonly></td>
                                    </tr>
                                    <tr>
                                        <td style="border: none;"></td>
                                        <td style="border: none;"></td>
                                        <td style="border: none;"></td>
                                        <td>
                                            <h3>Tax Rate (%)</h3>
                                        </td>
                                        <td><input type="text" name="tax_rate" class="form-control tax-rate" value="15" readonly></td>
                                    </tr>
                                    <tr>
                                        <td style="border: none;"></td>
                                        <td style="border: none;"></td>
                                        <td style="border: none;"></td>
                                        <td>
                                            <h3>Tax</h3>
                                        </td>
                                        <td><input type="text" name="tax" class="form-control tax" readonly></td>
                                    </tr>
                                    <tr>
                                        <td style="border: none;"></td>
                                        <td style="border: none;"></td>
                                        <td style="border: none;"></td>
                                        <td>
                                            <h3>Grand Total</h3>
                                        </td>
                                        <td><input type="text" name="grand_total" class="form-control grand-total" readonly></td>
                                    </tr>
                                </tfoot>
                            </table>
                            <br>
                            <br>
                            <div class="payment-method-group">
                                <label for="payment-method">Payment Method</label>
                                <select id="payment-method" name="payment_method">
                                    <option value="credit-card">Credit Card</option>
                                    <option value="bank-transfer">Bank Transfer</option>
                                    <option value="paypal">PayPal</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <input type="text" name="message" id="message" class="messageTextarea" placeholder="Enter custom message if you wish to override the default receipt type email msg!">
                            </div>

                            <div class="gen">
                                <div class="col-xs-6 margin-top btn-group">
                                    <button type="submit" class="btn btn-primary" id="generate-invoice">Submit Invoice</button>
                                </div>
                            </div>

                        </div>

                </section>
            </form>

        </main>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        //toogle
        const toggleMenu = document.getElementById("toggleMenu");
        const toggelMenuIcon = document.getElementById("toggelMenuIcon");
        const sideNav = document.getElementById("sideNav");
        const toggleTheme = document.getElementById("toggleTheme");
        const toggleThemeIcon = document.getElementById("toggleThemeIcon");

        toggleMenu.onclick = (e) => {
            sideNav.classList.toggle("showsideNav");
            toggelMenuIcon.classList.toggle("rotateToggelMenuIcon")
            toggleMenu.classList.toggle("slidetoggleMenu")
        }

        toggleTheme.onclick = () => {
            document.body.classList.toggle("darkTheme")
            e.target.classList.toggle("lightMoonIcon");
        }
        $(document).ready(function() {
            // Add new row
            $(document).on('click', '.addRow', function() {
                var tr = '<tr>' +
                    '<td><input type="text" name="product[]" class="form-control product"></td>' +
                    '<td><input type="text" name="qty[]" class="form-control qty"></td>' +
                    '<td><input type="text" name="price[]" class="form-control price"></td>' +
                    '<td><input type="text" name="discount[]" class="form-control discount"></td>' +
                    '<td><input type="text" name="amount[]" class="form-control amount"></td>' +
                    '<td><a href="#" class="btn btn-danger btn-xs remove"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span>Remove</a></td>' +
                    '<td><a href="#" class="btn btn-success btn-xs add"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span>Add</a></td>' +
                    '</tr>';
                $('tbody').append(tr);
            });

            // Add row
            $(document).on('click', '.add', function() {
                $(this).closest('tr').add();
                total();
            });

            // Remove row
            $(document).on('click', '.remove', function() {
                $(this).closest('tr').remove();
                total();
            });

            // Calculate total and tax
            function total() {
                var subtotal = 0;

                // Calculate subtotal
                $('.amount').each(function() {
                    var amount = $(this).val() - 0;
                    subtotal += amount;
                });

                // Set subtotal
                $('.total').val(subtotal);

                // Calculate and set tax
                var taxRate = $('.tax-rate').val() - 0; // Assume tax rate is provided as a percentage
                var tax = (subtotal * taxRate / 100);
                $('.tax').val(tax.toFixed(2)); // Set tax value

                // Calculate and set grand total
                var grandTotal = subtotal + tax;
                $('.grand-total').val(grandTotal.toFixed(2)); // Assuming there is a field for grand total
            }

            // Calculate amount on input change
            $(document).on('input', '.qty, .price, .discount', function() {
                var row = $(this).closest('tr');
                var qty = row.find('.qty').val() - 0;
                var price = row.find('.price').val() - 0;
                var discount = row.find('.discount').val() - 0;
                var amount = (qty * price) - discount;
                row.find('.amount').val(amount);
                total();
            });

            // Dark/Light mode toggle
            $("#toggleTheme").on("click", () => {
                let theme = $("html").attr("data-theme");
                if (theme === "light") {
                    $("html").attr("data-theme", "dark");
                } else {
                    $("html").attr("data-theme", "light");
                }
            });
        });
    </script>
</body>

</html>