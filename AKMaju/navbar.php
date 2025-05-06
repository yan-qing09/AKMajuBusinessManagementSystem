<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<?php if (!empty($message)) : ?>
    <div class="toast" role="alert" aria-live="assertive" aria-atomic="true" data-delay="5000" style="position: fixed; bottom: 10px; right: 10px; z-index: 1050;background-color:#fff ;">
        <div style="font-size: 18px;" class="toast-header bg-warning text-dark d-flex justify-content-between">
            <strong class="mr-auto">LOW STOCK ALERT</strong>
            <button class="btn-close" type="button" aria-label="Close" data-bs-dismiss="toast"></button>
        </div>
        <div class="toast-body" style="font-size: 15px;">
            <?php echo $message; ?>
        </div>
    </div>
<?php endif; ?>
<script>
    $(document).ready(function() {
        <?php if (!empty($message)) : ?>
            // Show the toast when the document is ready
            $('.toast').toast('show');
        <?php endif; ?>
    });
</script>
<nav class="navbar align-items-start sidebar sidebar-dark accordion bg-gradient-primary p-0 navbar-dark" style="color: rgb(45,49,84);background: rgb(102,43,55);">
    <div class="container-fluid d-flex flex-column p-0"><a class="navbar-brand d-flex justify-content-center align-items-center sidebar-brand m-0" href="#">
            <div class="sidebar-brand-icon"><img class="rounded-circle" src="assets/img/dogs/akmaju.jpg" style="width: 32px;"></div>
            <div class="sidebar-brand-text mx-3"><span>AK MAJU</span></div>
        </a>
        <hr class="sidebar-divider my-0">
        <ul class="navbar-nav text-light" id="accordionSidebar">
            <li class="nav-item">
                <?php 
                    echo"<a href='navdashboard.php?id=".$rows['U_id']."' class='nav-link active'>";
                    echo"<i class='fas fa-tachometer-alt'></i>";
                    echo"<span> Dashboard</span>";
                    echo"</a>";

                    echo"<a href='customer.php?id=".$rows['U_id']."' class='nav-link active'>";
                    echo"<i class='fas fa-users'></i>";
                    echo"<span> Customer Information</span>";
                    echo"</a>";
                ?>
            </li>
            <li class="nav-item">
                <?php 
                    echo"<a class='nav-link active' style='height: 40px;'>";
                    echo"<span style='color: rgb(255,255,255);font-weight: bold;'> Advertisement</span>";
                    echo"</a>";

                    echo"<a href='admaterial.php?id=".$rows['U_id']."' class='nav-link active' style='height: 45px;'>";
                    echo"<i class='fas fa-table'></i>";
                    echo"<span style='color: rgb(255,255,255);font-weight: bold;' class='pe-lg-0'> Materials</span>";
                    echo"</a>";

                    echo"<a href='AOrder.php?id=".$rows['U_id']."' class='nav-link active' style='height: 52.4px;'>";
                    echo"<i class='fa fa-shopping-basket'></i>";
                    echo"<span style='color: rgb(255,255,255);font-weight: bold;'> Orders</span>";
                    echo"</a>";
                ?>
            </li>
            <li class="nav-item">
                <?php 
                    echo"<a class='nav-link active' style='height: 40px;'>";
                    echo"<span style='color: rgb(255,255,255);font-weight: bold;'> Construction</span>";
                    echo"</a>";

                    echo"<a href='cmaterial.php?id=".$rows['U_id']."' class='nav-link active' style='height: 45px;'>";
                    echo"<i class='fas fa-table'></i>";
                    echo"<span style='color: rgb(255,255,255);font-weight: bold;' class='pe-lg-0'> Materials</span>";
                    echo"</a>";

                    echo"<a href='COrder.php?id=".$rows['U_id']."' class='nav-link active' style='height: 45px;'>";
                    echo"<i class='fa fa-shopping-basket'></i>";
                    echo"<span style='color: rgb(255,255,255);font-weight: bold;'> Orders</span>";
                    echo"</a>";

                    echo"<a href='rate.php?id=".$rows['U_id']."' class='nav-link active' style='height: 52.4px;'>";
                    echo"<i class='fa fa-calculator'></i>";
                    echo"<span style='color: rgb(255,255,255);font-weight: bold;'> Rates</span>";
                    echo"</a>";
                ?>
            </li>
            <li class="nav-item">
                <?php 
                    echo "<a href='signature.php?id=".$rows['U_id']."' class='nav-link active'>";
                    echo "<i class='far fa-copy'></i>";
                    echo "<span style='color: rgb(255,255,255);font-weight: bold;'> Signatures</span>";
                    echo "</a>";

                    echo "<a href='navverification.php?id=".$rows['U_id']."' class='nav-link active'>";
                    echo "<i class='fas fa-check'></i>";
                    echo "<span style='color: rgb(255,255,255);font-weight: bold;'> Document Verification</span>";
                    echo "</a>";

                    if ($rows['U_type'] === 'Admin') { 
                        echo "<a href='manageuser.php?id=".$rows['U_id']."' class='nav-link active'>";
                        echo "<i class='fa fa-user-o'></i>";
                        echo "<span style='color: rgb(255,255,255);font-weight: bold;'> Manage User</span>";
                        echo "</a>";
                    }
                ?>
            </li>
        </ul>
        <div class="text-center d-none d-md-inline"><button class="btn rounded-circle border-0" id="sidebarToggle" type="button"></button></div>
    </div>
</nav>