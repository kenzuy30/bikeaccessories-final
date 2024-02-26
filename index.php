<?php
include 'header.php';
if (!isset($_SESSION['logged_in'])) {
    header("Location: login.php");
    ob_end_flush();
}
?>

<div class="container-fluid d-flex justify-content-center">
    <div class="tab-content d-flex my-5 justify-content-center align-items-center" id="v-pills-tabContent" style="height: 300px;">

        <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab" tabindex="0">
        <div class="container d-flex justify-content-center py-2 mb-3" style="font-size: .8rem">
                        <div class="search_main">
                            <div class="student_search">
                                <form action="" method="POST">
                                    <input type="hidden" name="userID" value="<?= $_SESSION['u_id'] ?>">
                                    <input class="rounded-4 px-3 py-1 " type="text" name="items" value="" placeholder="Search Accessory">
                                    <input class="rounded-4 px-2 py-1" type="submit" name="search" value="Search">
                                </form>
                                <?php
                                if (isset($_POST['search'])) {
                                ?>
                                    <div class="container d-flex justify-content-center ">
                                        <table class="table mt-2 table-bordered ">
                                            <thead class="alert-info">
                                            </thead>
                                            <tbody>
                                                <?php
                                                $userID = $_POST['userID'];
                                                $word = $_POST['items'];
                                                $getAcces = $conn->prepare("SELECT * FROM `accessories` WHERE `userID` LIKE '%$userID%' AND `items` LIKE '%$word%'");
                                                $getAcces->execute();
                                                foreach ($getAcces as $acces) {
                                                ?>
                                                    <tr>
                                                        <td><?= $acces['items'] ?></td>
                                                        <td><?= $acces['price'] ?></td>
                                                        <td><?= $acces['quantity'] ?></td>
                                                    </tr>
                                
                                
                                                <?php
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                <?php
                                }
                                ?>
                            </div>
                        </div>
                    </div>
            <div class="px-2 position-relative" style="font-size: .8rem;">

                <table class="table">
                    <thead align="center">
                        <tr>
                            <th scope="col" class="px-md-4">#</th>
                            <th scope="col" class="text-start px-md-4">Accessories</th>
                            <th scope="col" class="px-md-4">Price</th>
                            <th scope="col" class="px-md-4">Quantity</th>
                            <th scope="col" class="px-md-4">Total</th>
                            <th scope="col" class="px-md-4">Action</th>
                        </tr>
                    </thead>
                    <tbody align="center">

                        <?php
                           $userID = $_SESSION['u_id'];
                           $getID = $conn->prepare("SELECT COUNT(*) FROM accessories WHERE userID=?");
                           $getID->execute([$userID]);

                           $total = $getID->fetchColumn();

                           $items = 5;
                           $cnt = 1;

                           $current = isset($_GET['page']) ? max(1, $_GET['page']) : 1;

                           $offset = ($current - 1) * $items;

                           $getData = $conn->prepare("SELECT * FROM accessories WHERE userID=? LIMIT $offset, $items");
                           $getData->execute([$userID]);
                        foreach($getData as $data) { ?>
                            <tr>
                                <th class="px-md-4"><?= $cnt++ ?></th>
                                <td class="px-md-4"><?= $data['items'] ?></td>
                                <td class="px-md-4"><?= $data['price'] ?></td>
                                <td class="px-md-4"><?= $data['quantity'] ?></td>
                                <td class="px-md-4"><?= $data['price'] * $data['quantity'] ?></td>
                                <td class="px-md-1">
                                        <a class="text-decoration-none px-1 " href="new.php?update&id=<?= $data['p_id'] ?>" class="text-decoration-none">✏</a>
                                        |
                                        <a class="text-decoration-none px-1 " href="backend.php?delete&id=<?= $data['p_id'] ?>" class="text-decoration-none">❌</a>
                                </td>
                            </tr>
                            <?php } ?>

                    </tbody>
                </table>
            </div>
            <div class="container d-flex justify-content-center ">
                <nav aria-label="Page navigation">
                    <ul class="pagination">
                        <?php
                        for ($i = 1; $i <= ceil($total / $items); $i++) { ?>
                            <li class="page-item bg-transparent">
                                <a class="page-link text-success bg-transparent " href="?page=<?= $i ?>">•</a>
                            </li>
                        <?php } ?>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>