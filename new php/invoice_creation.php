<?php
session_start();
include('db.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect client information
    $client_name = $_POST['client_name'];
    $client_email = $_POST['client_email'];
    $client_address1 = $_POST['client_address1'];
    $client_address2 = $_POST['client_address2'];
    $client_town = $_POST['client_town'];
    $client_country = $_POST['client_country'];
    $client_postcode = $_POST['client_postcode'];

    // Insert client information into the clients table
    $sql = "INSERT INTO clients (name, email, address1, address2, town, country, postcode) 
            VALUES ('$client_name', '$client_email', '$client_address1', '$client_address2', '$client_town', '$client_country', '$client_postcode')";
    if ($conn->query($sql) === TRUE) {
        $client_id = $conn->insert_id;

        // Collect invoice information
        $date = $_POST['date'];
        $due_date = $_POST['due_date'];
        $items = $_POST['items'];
        $quantities = $_POST['quantities'];
        $unit_prices = $_POST['unit_prices'];
        $discounts = $_POST['discounts'];
        $total_amount = 0;

        // Generate a unique invoice number
        $invoice_number = 'INV' . time();

        // Insert invoice
        $sql = "INSERT INTO invoices (client_id, invoice_number, date, due_date, total_amount, status) 
                VALUES ('$client_id', '$invoice_number', '$date', '$due_date', 0, 'Pending')";
        if ($conn->query($sql) === TRUE) {
            $invoice_id = $conn->insert_id;

            // Insert invoice items and calculate total amount
            for ($i = 0; $i < count($items); $i++) {
                $description = $items[$i];
                $quantity = $quantities[$i];
                $unit_price = $unit_prices[$i];
                $discount = isset($discounts[$i]) ? $discounts[$i] : 0;
                $total_price = ($quantity * $unit_price) - $discount;
                $total_amount += $total_price;

                $sql = "INSERT INTO invoice_items (invoice_id, invoice_number, description, quantity, unit_price, total_price, discount) 
                        VALUES ('$invoice_id', '$invoice_number', '$description', '$quantity', '$unit_price', '$total_price', '$discount')";
                $conn->query($sql);
            }

            // Update total amount in invoice
            $sql = "UPDATE invoices SET total_amount='$total_amount' WHERE invoice_id='$invoice_id'";
            $conn->query($sql);

            echo "Invoice created successfully!";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

?>

<?php include('subfolder/main.php'); ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User | Landing</title>
    <link rel="stylesheet" href="invoice_creation.css">
    <script src="https://kit.fontawesome.com/aa7454d09f.js" crossorigin="anonymous"></script>
</head>

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
                        <li class="navLink ">
                            <a href="user_landing_page.php">
                                <i class="fa-solid fa-gauge icon"></i>
                                Home
                            </a>
                        </li>
                        <li class="navLink activeNavLink">
                            <i class="fa-solid fa-mug-hot"></i>
                            <a href="invoice_creation.php">Invoice Creation</a>
                        </li>
                        <li class="navLink" id="invoiceCreationNav">
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
                        <li class="navLink">
                            <i class="fa-solid fa-wallet icon"></i>
                            <a href="receipt_management.php">Receipt Management</a>
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
                <h1 class="headline">Invoice</h1>
            </div>

            <form method="POST" action="">
                <div class="form-group float-right">
                    <div class="input-group col-xs-4">
                        <span class="input-group-addon"># Invoice Number</span>
                        <!-- Display invoice Number -->
                        <input type="text" name="invoice_number" id="invoice_number" class="form-control required" placeholder="Invoice Number" value="<?php echo isset($invoice_number) ? $invoice_number : ''; ?>" readonly>
                    </div>
                </div>

                <section class="invoice-form">
                    <div class="form-container">
                        <div class="form-section">

                            <!-- Get Client Information -->

                            <h2>Client Information</h2>
                            <div class="form-group">
                                <label for="client_name">Client Name</label>
                                <input type="text" id="client_name" name="client_name" placeholder="Client Name" required>
                            </div>
                            <div class="form-group">
                                <label for="client_email">E-mail Address</label>
                                <input type="email" id="client_email" name="client_email" placeholder="E-mail Address" required>
                            </div>
                            <div class="form-group">
                                <label for="client_address1">Address 1</label>
                                <input type="text" id="client_address1" name="client_address1" placeholder="Address 1" required>
                            </div>
                            <div class="form-group">
                                <label for="client_address2">Address 2</label>
                                <input type="text" id="client_address2" name="client_address2" placeholder="Address 2">
                            </div>
                            <div class="form-group">
                                <label for="date">Invoice Date:</label>
                                <input type="date" id="date" name="date" class="form-control required">
                            </div>
                            <div class="form-group">
                                <label for="due_date">Due Date:</label>
                                <input type="date" id="due_date" name="due_date" class="form-control required">
                            </div>
                            <div class="form-group">
                                <label for="client_town">Town</label>
                                <input type="text" id="client_town" name="client_town" placeholder="Town">
                            </div>
                            <div class="form-group">
                                <label for="client_country">Country</label>
                                <input type="text" id="client_country" name="client_country" placeholder="Country">
                            </div>
                            <div class="form-group">
                                <label for="client_postcode">Postcode</label>
                                <input type="text" id="client_postcode" name="client_postcode" placeholder="Postcode">
                            </div>
                        </div>
                    </div>
                </section>

                <h2>Invoice Items</h2>
                <div id="invoice-items">
                    <div class="form-group">
                        <label for="items[]">Item Description:</label>
                        <input type="text" name="items[]" required>
                    </div>
                    <div class="form-group">
                        <label for="quantities[]">Quantity:</label>
                        <input type="number" name="quantities[]" required>
                    </div>
                    <div class="form-group">
                        <label for="unit_prices[]">Unit Price:</label>
                        <input type="number" step="0.01" name="unit_prices[]" required>
                    </div>
                    <div class="form-group">
                        <label for="discounts[]">Discount:</label>
                        <input type="number" step="0.01" name="discounts[]" value="0">
                    </div>
                </div>

                <button type="button" onclick="addItem()">Add Item</button>
                <br>
                <br>
                <button type="submit">Create Invoice</button>
            </form>

            <script>
                document.getElementById('generate-invoice').addEventListener('click', function() {
                    window.location.href = 'generatePDF.php';
                });

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

                // Get all navigation links
                const navLinks = document.querySelectorAll('.navLink');
                const contentSections = document.querySelectorAll('.content');

                // Add click event listener to each link
                navLinks.forEach(link => {
                    link.addEventListener('click', function() {
                        // Remove 'activeNavLink' class from all links
                        navLinks.forEach(link => link.classList.remove('activeNavLink'));

                        // Add 'activeNavLink' class to the clicked link
                        this.classList.add('activeNavLink');

                        // Hide all content sections
                        contentSections.forEach(section => section.classList.remove('activeContent'));

                        // Show the corresponding content section
                        const targetContent = this.querySelector('a').getAttribute('href').substring(1) + 'Content';
                        document.getElementById(targetContent).classList.add('activeContent');
                    });
                });
            </script>
        </main>
    </div>
</body>

</html>