<?php
require_once "database.php";

//hàm lấy ra dữ liệu danh sách hàng hóa
function product_list_all() {
    $sql = "SELECT products.*,categories.name as name_cate from products inner join categories on categories.id = products.id_category 
    ORDER BY id DESC";
    return query_exe($sql);
}

//function lấy ra dữ liệu theo loại hàng
//$id_cate là dữ liệu được lọc
function product_list_cate($id_category) {
    $sql = "SELECT * from products Where id_category=$id_category ORDER BY id DESC";
    return query_exe($sql);
}

//hàm lấy ra dữ liệu danh sách hàng hóa theo danh mục và giới hạn
function product_list_categories($id_category,$limit, $nRows) {
    $sql = "SELECT products.* from products inner join categories on products.id_category = categories.id 
    Where id_category=$id_category
    ORDER BY products.id DESC limit $limit,$nRows";
    return query_exe($sql);
}

//Ham tinh tong so ban ghi trong bảng products theo dieu kien
function num_row($id_category){
    $conn = connection();
    $sql = $conn->prepare("SELECT COUNT(*) from products inner join categories on products.id_category = categories.id 
    Where id_category=$id_category");
    $sql->execute(); 
    $num_row = $sql->fetchColumn();
    return $num_row;
}

//Sản phẩm liên quan
function product_list_category($id_category,$id) {
    $sql = "SELECT * from products  Where id_category=$id_category and id != $id ORDER BY id DESC";
    return query_exe($sql);
}

//Hiển thị sản phẩm theo trạng thái
function product_list($status) {
    $sql = "SELECT products.*,categories.name as name_cate from products inner join categories on categories.id = products.id_category 
     Where status=$status ORDER BY id DESC";
    return query_exe($sql);
}
//function lấy ra dữ liệu theo limit
//$sql câu lệnh select
function product_list_limit($limit, $nRows) {
    $sql = "SELECT * from products order by id desc limit $limit, $nRows";
    return query($sql);
}

//Hiển thị những sản phẩm có lượt view cao
function product_list_view($limit, $nRows) {
    $sql = "SELECT * from products order by views desc limit $limit, $nRows";
    return query($sql);
}

//Lấy ra 1 bản ghi hàng hóa theo điều kiện id
function product_list_one($id) {
    return listOne('products', 'id', $id);
}

//San pham giam gia
function list_sale_product($limit, $nRows){
    $arr = ['sale','>',0];
    return query_where('products',$arr,$limit, $nRows);
}

//Ham tinh tong so ban ghi theo dieu kien sale>0
function count_sale(){
    $conn = connection();
    $sql = $conn->prepare("SELECT COUNT(*) from products
    Where sale > 0");
    $sql->execute(); 
    $num_row = $sql->fetchColumn();
    return $num_row;
}

//Chỉnh sửa dữ liệu hàng hóa
function product_update($id, $name, $price, $sale, $images, $id_category, $status, $description) {
    $data = [        
        "name"=>$name,
        "price"=>$price,
        "sale"=>$sale,
        "images"=>$images,
        "id_category"=>$id_category,
        "status"=>$status,
        "description"=>$description
    ];
    return update('products', $data,'id', $id);
}

//function thêm hàng hóa vào bảng hàng hóa
function product_insert($name, $price, $sale, $images, $id_category, $status, $description) {
    $data = [        
        "name"=>$name,
        "price"=>$price,
        "sale"=>$sale,
        "images"=>$images,
        "id_category"=>$id_category,
        "status"=>$status,
        "views"=>0,
        "description"=>$description
    ];
    return insert('products', $data);
}

//Xóa hàng hóa
function product_delete($id) {
    $row = product_list_one($id);
    
    if ( $row ) {
        //Xóa cả hình khi xóa dữ liệu
        $images = "../images/products/" . $row['images'];
        
        if ( file_exists($images)) {
            unlink($images);
        } 
        delete('products', 'id', $id);
    }
}

//hàm cập nhật số lượt xem
function update_view($id){
    $sql = "UPDATE products SET views=views+1 where id=$id";
    return query_exe($sql);
}

//Tìm kiếm theo tên sản phẩm
function search_product($name){
    $sql = "SELECT p.id, p.name, p.images, status, price, description ,sale, views
    FROM products p INNER JOIN categories c on p.id_category = c.id 
    Where p.name Like '%$name%'";
    return query_exe($sql);
}

//Thống kê hàng hóa theo danh mục
function statistical_product(){
    $sql = "SELECT c.id, c.name, COUNT(*) so_luong, MIN(p.price) gia_min, MAX(p.price) gia_max, AVG(p.price) gia_avg
     FROM products p inner JOIN categories c ON c.id=p.id_category
     GROUP BY c.id, c.name";
return query_exe($sql);
}