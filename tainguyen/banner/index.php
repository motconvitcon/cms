<?php
    include('tainguyen/banner/xoa.php');
    //Lấy dữ liệu từ database
    //Liên kết content <=> modul
    $sql=("SELECT b_banner.*,
            b_modul.tieude as tieudemodul
        FROM b_banner 
            left outer join b_modul on b_modul.ma=b_banner.modul
            limit " . (($_GET['page'] - 1) * $ban_ghi) . "," . $ban_ghi);
    $q=$conn->prepare($sql);
    $q->execute();
    $view_all = $q->fetchAll();
    if (empty($_GET['page'])) {
        $_GET['page'] = 1;
    }
    $ban_ghi = 10
?>
<section>
    <div class="container-fluid">
        <h2 class="float-start fs-4">Danh Sách Banner</h2>
        <a href="?thumuc=<?=$_GET['thumuc']?>&file=themmoi" class="float-end mt-2 mb-3 me-3 text-decoration-none btn btn-primary"><i class="bi bi-plus-lg"></i> Thêm Banner</a>
        <div class="clearfix "></div>
        <hr class="mt-0">
        <table class="table border table table-hover table-bordered bg-white">
            <tr>
                <th>STT</th>
                <th>Tiêu Đề</th>
                <th>Mô tả</th>
                <th>Link</th>
                <th>Modul</th>
                <th>Ghi Chú</th>
                <th>Trạng thái</th>
                <th class="text-center">Sửa</th>
                <th class="text-center">Xóa</th>
            </tr>

            <tbody>
                <?php
                $i = 1;
                foreach ($view_all as $key => $info) {
                    echo '<tr>
                            <td>' . ($i++) . '</td>
                            <td>' . $info['tieude'] . '</td>
                            <td>' . $info['mo_ta'] . '</td>
                            <td>' . $info['img_path'] . '</td>
                            <td>' . $info['tieudemodul'] . '</td>
                            <td>' . $info['ghichu'] . '</td>';
                    if ($info['hienthi'] == 1) {
                        echo '<td><p class="text-success">Hiển Thị</p></td>';
                    } else {
                        echo '<td><p class="text-danger">Ẩn</p></td>';
                    }
                    echo '<td class="text-center"><a href="?thumuc='.$_GET['thumuc'].'&file=sua&id=' . $info['id'] . '" class="btn btn-primary btn-sm">Sửa</a></td>
                            <td class="text-center"><button class="btn btn-danger btn-sm" onclick="xoa(' . $info['id'] . ')">Xóa</button></td>
                        </tr>';
                }
                
                ?>
            </tbody>
        </table>
        <section>
            <form action="" method="post" id="IDdel">
                <input type="hidden" id="delete" name="iddelete" value="">
            </form>
        </section>
        <script type="text/javascript">
            function xoa(id) {
                
                if (confirm("Bạn có chắc chắn muốn xóa hay không ?")) {
                    var del=document.getElementById("delete");
                    del.value=id;
                    console.log(del);
                    var autodel = document.getElementById("IDdel");
                    autodel.submit();
                }
            }
        </script>
        <nav aria-label="Page navigation example" style="margin-left: 49%;">
            <ul class="pagination m-0">

                <?php
                $q = $conn->prepare("SELECT * from b_banner order by id ASC");
                $q->execute();
                $rc = $q->rowCount();
                $tong_page = 0;
                if ($rc % $ban_ghi == 0) {
                    $tong_page = floor($rc / $ban_ghi);
                } else {
                    $tong_page = floor($rc / $ban_ghi) + 1;
                }
                if ($_GET['page'] > 1) {
                    echo '<li class="page-item"><a class="page-link" href="?thumuc='.$_GET['thumuc'].'&file=index&page=' . ($_GET['page'] - 1) . '">Trước</a></li>';
                }
                for ($i = $_GET['page'] - 2; $i <= $_GET['page'] + 2; $i++) {

                    if ($i == $_GET['page'] && $i <= $tong_page) {
                        echo '<li class="page-item active"><a class="page-link" href="?thumuc='.$_GET['thumuc'].'&file=index&page=' . $i . '">' . $i . '</a></li>';
                    } else {
                        if ($i > 0 && $i <= $tong_page) {
                            echo '<li class="page-item"><a class="page-link" href="?thumuc='.$_GET['thumuc'].'&file=index&page=' . $i . '">' . $i . '</a></li>';
                        }
                    }
                }
                if ($_GET['page'] < $tong_page) {
                    echo '<li class="page-item"><a class="page-link" href="?thumuc='.$_GET['thumuc'].'&file=index&page=' . ($_GET['page'] + 1) . '">Sau</a></li>';
                }
                ?>

            </ul>


        </nav>
        <div class="text-center" style="font-size: 12px;"><p class="" style="margin-left: 100%;"><?php echo '<p>Trang ' . $_GET['page'] . '/' . $tong_page . '</p>'; ?></p></div>
    </div>
    </div>
</section> 