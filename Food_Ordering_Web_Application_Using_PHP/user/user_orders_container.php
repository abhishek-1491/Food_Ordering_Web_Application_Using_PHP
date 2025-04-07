<section class="orders tabcontent " id="orders">
    <div class="orders-content">
        <h1>All Orders</h1>
        <div class="orders-table">
            <table>
                <tr>
                    <th>Sr. No</th>
                    <th>Invoice No</th>
                    <th>Ordered Dishes</th>
                    <th>Total Payment</th>
                    <th>Ordered Date</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>

                <?php
                foreach ($allOrders as $key => $singleorder) {
                    ?>
                    <tr>
                        <td>
                            <?php echo $key + 1 ?>
                        </td>
                        <td>
                            <?php echo $singleorder['invoice_no'] ?>
                        </td>
                        <td>
                            <?php echo implode(", ", $singleorder['dishes']) ?>
                        </td>
                        <td>
                            ₹<?php echo $singleorder['total_payment'] ?>
                        </td>
                        <td>
                            <?php echo $singleorder['ordered_date'] ?>
                        </td>
                        <td>
                            <?php echo $singleorder['status'] ?>
                        </td>
                        <td>
                            <button>View Order</button>
                        </td>
                    </tr>
                    <?php
                }
                ?>

            </table>
        </div>
    </div>
</section>