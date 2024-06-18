<?php
/**
 * Created by PhpStorm.
 * User: Desenvolvimento 2
 * Date: 09/02/2018
 * Time: 11:34
 */


require_once("mail/class.phpmailer.php");

if (session_status() == PHP_SESSION_NONE) {
    @session_start();
}

function debug()
{
    ini_set('display_startup_errors', 1);
    ini_set('display_errors', 1);
    error_reporting(-1);
}


function redirect($location = false)
{
    if ($location) {
        header("Location: " . $location);
    } else {
        header("Location:" . $_SERVER['HTTP_REFERER']);
    }
}

function redirect_js($dest = false)
{
    if (!$dest) back();
    echo "<script>window.location.href = '$dest' </script>";
}

function first_config()
{
    global $dataBase;
    if (!$dataBase) return true;
    @$result = $dataBase->query("SHOW TABLES LIKE 'tb_usuario'");
    if (!$result) return true;
    return (!$result->num_rows);
}

function create_table_user($user = 'tr1', $senha = 'tr1web10')
{
    global $dataBase;
    if (first_config()) {
        $sql = "CREATE TABLE tb_usuario (
                          usu_id int PRIMARY KEY AUTO_INCREMENT,
                          usu_nome varchar(55) NOT NULL,
                          usu_login varchar(65) NOT NULL,
                          usu_senha varchar(100) NOT NULL,
                          usu_status tinyint NOT NULL DEFAULT 1
                        );";
        $dataBase->query($sql);
        $sql = "INSERT INTO tb_usuario(usu_nome, usu_login, usu_senha) VALUES('$user','$user','" . cript($senha) . "')";
        $dataBase->query($sql) OR DIE(mysqli_error($dataBase));
    }
}

function write_config($title, $host, $db, $user, $pass, $path, $url)
{
    $break = "\n";
    $path = str_replace('\\', '\\\\', $path);
    $str = "<?php " . $break;
//    $str .= '$config=array();'.$break;
    $str .= '$db_host = "' . $host . '";' . $break;
    $str .= '$db_base = "' . $db . '";' . $break;
    $str .= '$db_user = "' . $user . '";' . $break;
    $str .= '$db_password = "' . $pass . '";' . $break;
    $str .= '$title_site = "' . $title . '";' . $break;
    $str .= 'DEFINE("BASE_URL", "' . $url . '");' . $break;
    $str .= 'DEFINE("BASE_PATH", "' . $path . '");' . $break;

    $arq = fopen("config.php", 'w');
    fwrite($arq, $str);
    fclose($arq);
}

function site_url($path = '')
{
    return BASE_URL . $path;
}

function path($path = '')
{
    return BASE_PATH . $path;
}

function cript($pass)
{
    $salt = "RONALDINHO GAUCHO";
    return sha1($pass . md5($salt));
}

function flash_data($name, $data = false)
{
    if ($data) {
        $_SESSION[$name] = $data;
    } else {
        if (!isset($_SESSION[$name])) return false;
        $aux = $_SESSION[$name];
        $_SESSION[$name] = null;
        return $aux;
    }
}

function switch_generator($active = false, $id = 1) {
?>
    <div class="switch tiny">
        <input class="switch-input" id="<?php echo $id ?>" type="checkbox"
               name="<?php echo $id ?>" <?php echo $active ? "checked = 'true'" : "" ?> onchange="status(this)">
        <label class="switch-paddle" for="<?php echo $id ?>">
            <span class="show-for-sr">Download Kittens</span>
        </label>
    </div>
<?php }

function toast($title, $txt, $type = 0)
{
    $types = array('error', 'success');
    flash_data('data',
        array(
            "type" => $types[$type],
            'text' => $txt,
            'title' => $title
        ));
}

function category_list($category_parent_id = 0, $compare = 0)
{

// build our category list only once
    static $cats;
    global $dataBase;

    if (!is_array($cats)) {
        $query = mysqli_query($dataBase, "SELECT * FROM tb_categorias");

        while ($cat = mysqli_fetch_array($query)) {
            $cats[] = $cat;
        }

    }

// populate a list items array
    $list_items = array();

    foreach ($cats as $cat) {

        // if not a match, move on
        if (( int )$cat['fk_cat_id'] !== ( int )$category_parent_id) {
            continue;
        }

        // open the list item
        $list_items[] = '<li id="' . $cat['cat_id'] . '">';

        // construct the category link
        $list_items[] = '<label>';
        if ($compare) {
            if (in_array((string)$cat['id_cat'], $compare)) {
                $list_items[] = '<input type="checkbox" name="cats[]" value="' . $cat['cat_id'] . '" checked> ' . $cat['cat_nome'];
            } else {
                $list_items[] = '<input type="checkbox" name="cats[]" value="' . $cat['cat_id'] . '"> ' . $cat['cat_nome'];
            }
        } else $list_items[] = '<input type="checkbox" name="cats[]" value="' . $cat['cat_id'] . '"> ' . $cat['cat_nome'];
        $list_items[] = '</label>';

        // recurse into the child list
        $list_items[] = category_list($cat['cat_id'], $compare);

        // close the list item
        $list_items[] = '</li>';

    }

// convert to a string
    $list_items = implode('', $list_items);

// if empty, no list items!
    if ('' == trim($list_items)) {
        return '';
    }

// ...otherwise, return the list
    return '<ul class="list-ul">' . $list_items . '</ul>';

}

function category_list_json()
{

// build our category list only once
    global $dataBase;

    $query = mysqli_query($dataBase, "SELECT cat_id as id, cat_nome as text, IF(cat_gru_id=0,'#',cat_gru_id) as parent, cat_status FROM tb_categoria ");

    while ($cat = mysqli_fetch_assoc($query)) {
        if (!$cat['cat_status']) {

            $cat['icon'] = site_url('adm/assets/img/folder-off.png');
        }
        $cats[] = $cat;
    }

    return json_encode($cats);

}


function generateSeoURL($string, $wordLimit = 0)
{
    $separator = '-';

    if ($wordLimit != 0) {
        $wordArr = explode(' ', $string);
        $string = implode(' ', array_slice($wordArr, 0, $wordLimit));
    }

    $quoteSeparator = preg_quote($separator, '#');

    $trans = array(
        '&.+?;' => '',
        '[^\w\d _-]' => '',
        '\s+' => $separator,
        '(' . $quoteSeparator . ')+' => $separator
    );

    $string = strip_tags($string);
    foreach ($trans as $key => $val) {
        $string = preg_replace('#' . $key . '#i' . (1 ? 'u' : ''), $val, $string);
    }

    $string = strtolower($string);

    return trim(trim($string, $separator));
}

function remove_accents($string)
{
    if (!preg_match('/[\x80-\xff]/', $string))
        return $string;

    $chars = array(
        // Decompositions for Latin-1 Supplement
        chr(195) . chr(128) => 'A', chr(195) . chr(129) => 'A',
        chr(195) . chr(130) => 'A', chr(195) . chr(131) => 'A',
        chr(195) . chr(132) => 'A', chr(195) . chr(133) => 'A',
        chr(195) . chr(135) => 'C', chr(195) . chr(136) => 'E',
        chr(195) . chr(137) => 'E', chr(195) . chr(138) => 'E',
        chr(195) . chr(139) => 'E', chr(195) . chr(140) => 'I',
        chr(195) . chr(141) => 'I', chr(195) . chr(142) => 'I',
        chr(195) . chr(143) => 'I', chr(195) . chr(145) => 'N',
        chr(195) . chr(146) => 'O', chr(195) . chr(147) => 'O',
        chr(195) . chr(148) => 'O', chr(195) . chr(149) => 'O',
        chr(195) . chr(150) => 'O', chr(195) . chr(153) => 'U',
        chr(195) . chr(154) => 'U', chr(195) . chr(155) => 'U',
        chr(195) . chr(156) => 'U', chr(195) . chr(157) => 'Y',
        chr(195) . chr(159) => 's', chr(195) . chr(160) => 'a',
        chr(195) . chr(161) => 'a', chr(195) . chr(162) => 'a',
        chr(195) . chr(163) => 'a', chr(195) . chr(164) => 'a',
        chr(195) . chr(165) => 'a', chr(195) . chr(167) => 'c',
        chr(195) . chr(168) => 'e', chr(195) . chr(169) => 'e',
        chr(195) . chr(170) => 'e', chr(195) . chr(171) => 'e',
        chr(195) . chr(172) => 'i', chr(195) . chr(173) => 'i',
        chr(195) . chr(174) => 'i', chr(195) . chr(175) => 'i',
        chr(195) . chr(177) => 'n', chr(195) . chr(178) => 'o',
        chr(195) . chr(179) => 'o', chr(195) . chr(180) => 'o',
        chr(195) . chr(181) => 'o', chr(195) . chr(182) => 'o',
        chr(195) . chr(182) => 'o', chr(195) . chr(185) => 'u',
        chr(195) . chr(186) => 'u', chr(195) . chr(187) => 'u',
        chr(195) . chr(188) => 'u', chr(195) . chr(189) => 'y',
        chr(195) . chr(191) => 'y',
        // Decompositions for Latin Extended-A
        chr(196) . chr(128) => 'A', chr(196) . chr(129) => 'a',
        chr(196) . chr(130) => 'A', chr(196) . chr(131) => 'a',
        chr(196) . chr(132) => 'A', chr(196) . chr(133) => 'a',
        chr(196) . chr(134) => 'C', chr(196) . chr(135) => 'c',
        chr(196) . chr(136) => 'C', chr(196) . chr(137) => 'c',
        chr(196) . chr(138) => 'C', chr(196) . chr(139) => 'c',
        chr(196) . chr(140) => 'C', chr(196) . chr(141) => 'c',
        chr(196) . chr(142) => 'D', chr(196) . chr(143) => 'd',
        chr(196) . chr(144) => 'D', chr(196) . chr(145) => 'd',
        chr(196) . chr(146) => 'E', chr(196) . chr(147) => 'e',
        chr(196) . chr(148) => 'E', chr(196) . chr(149) => 'e',
        chr(196) . chr(150) => 'E', chr(196) . chr(151) => 'e',
        chr(196) . chr(152) => 'E', chr(196) . chr(153) => 'e',
        chr(196) . chr(154) => 'E', chr(196) . chr(155) => 'e',
        chr(196) . chr(156) => 'G', chr(196) . chr(157) => 'g',
        chr(196) . chr(158) => 'G', chr(196) . chr(159) => 'g',
        chr(196) . chr(160) => 'G', chr(196) . chr(161) => 'g',
        chr(196) . chr(162) => 'G', chr(196) . chr(163) => 'g',
        chr(196) . chr(164) => 'H', chr(196) . chr(165) => 'h',
        chr(196) . chr(166) => 'H', chr(196) . chr(167) => 'h',
        chr(196) . chr(168) => 'I', chr(196) . chr(169) => 'i',
        chr(196) . chr(170) => 'I', chr(196) . chr(171) => 'i',
        chr(196) . chr(172) => 'I', chr(196) . chr(173) => 'i',
        chr(196) . chr(174) => 'I', chr(196) . chr(175) => 'i',
        chr(196) . chr(176) => 'I', chr(196) . chr(177) => 'i',
        chr(196) . chr(178) => 'IJ', chr(196) . chr(179) => 'ij',
        chr(196) . chr(180) => 'J', chr(196) . chr(181) => 'j',
        chr(196) . chr(182) => 'K', chr(196) . chr(183) => 'k',
        chr(196) . chr(184) => 'k', chr(196) . chr(185) => 'L',
        chr(196) . chr(186) => 'l', chr(196) . chr(187) => 'L',
        chr(196) . chr(188) => 'l', chr(196) . chr(189) => 'L',
        chr(196) . chr(190) => 'l', chr(196) . chr(191) => 'L',
        chr(197) . chr(128) => 'l', chr(197) . chr(129) => 'L',
        chr(197) . chr(130) => 'l', chr(197) . chr(131) => 'N',
        chr(197) . chr(132) => 'n', chr(197) . chr(133) => 'N',
        chr(197) . chr(134) => 'n', chr(197) . chr(135) => 'N',
        chr(197) . chr(136) => 'n', chr(197) . chr(137) => 'N',
        chr(197) . chr(138) => 'n', chr(197) . chr(139) => 'N',
        chr(197) . chr(140) => 'O', chr(197) . chr(141) => 'o',
        chr(197) . chr(142) => 'O', chr(197) . chr(143) => 'o',
        chr(197) . chr(144) => 'O', chr(197) . chr(145) => 'o',
        chr(197) . chr(146) => 'OE', chr(197) . chr(147) => 'oe',
        chr(197) . chr(148) => 'R', chr(197) . chr(149) => 'r',
        chr(197) . chr(150) => 'R', chr(197) . chr(151) => 'r',
        chr(197) . chr(152) => 'R', chr(197) . chr(153) => 'r',
        chr(197) . chr(154) => 'S', chr(197) . chr(155) => 's',
        chr(197) . chr(156) => 'S', chr(197) . chr(157) => 's',
        chr(197) . chr(158) => 'S', chr(197) . chr(159) => 's',
        chr(197) . chr(160) => 'S', chr(197) . chr(161) => 's',
        chr(197) . chr(162) => 'T', chr(197) . chr(163) => 't',
        chr(197) . chr(164) => 'T', chr(197) . chr(165) => 't',
        chr(197) . chr(166) => 'T', chr(197) . chr(167) => 't',
        chr(197) . chr(168) => 'U', chr(197) . chr(169) => 'u',
        chr(197) . chr(170) => 'U', chr(197) . chr(171) => 'u',
        chr(197) . chr(172) => 'U', chr(197) . chr(173) => 'u',
        chr(197) . chr(174) => 'U', chr(197) . chr(175) => 'u',
        chr(197) . chr(176) => 'U', chr(197) . chr(177) => 'u',
        chr(197) . chr(178) => 'U', chr(197) . chr(179) => 'u',
        chr(197) . chr(180) => 'W', chr(197) . chr(181) => 'w',
        chr(197) . chr(182) => 'Y', chr(197) . chr(183) => 'y',
        chr(197) . chr(184) => 'Y', chr(197) . chr(185) => 'Z',
        chr(197) . chr(186) => 'z', chr(197) . chr(187) => 'Z',
        chr(197) . chr(188) => 'z', chr(197) . chr(189) => 'Z',
        chr(197) . chr(190) => 'z', chr(197) . chr(191) => 's'
    );

    $string = strtr($string, $chars);

    return $string;
}

function upload_fotos($file, $folder)
{
    if (isset($file['fotos']['name'][0]) && !empty($file['fotos']['name'][0]) && $file['fotos']['name'][0] != '') {

        $ext_permitidas = array('jpg', 'png', 'jpeg');
        $output_dir = BASE_PATH ."uploads/".$folder."/";
        $fileCount = count($file["fotos"]["name"]);

        for ($i = 0; $i < $fileCount; $i++) {
            $fileName = $file["fotos"]["name"][$i];
            $ext = pathinfo($file['fotos']['name'][$i], PATHINFO_EXTENSION);

            if (!in_array($ext, $ext_permitidas)) continue;
            $new_file_name = md5($fileName . filesize($file["fotos"]["tmp_name"][$i]) . date('s i')) . "." . $ext;
            //var_dump($output_dir);
            //exit;
            move_uploaded_file($file["fotos"]["tmp_name"][$i], $output_dir . $new_file_name);
            return $new_file_name;
        }
    } else return false;

}

function upload_multiple_fotos($file, $folder)
{
    if (isset($file['name'][0]) && !empty($file['name'][0]) && $file['name'][0] != '') {

        $ext_permitidas = array('jpg', 'png', 'jpeg');
        $output_dir = BASE_PATH ."uploads/".$folder."/";
        $fileCount = count($file["name"]);

        $arrayFilesName = array();

        for ($i = 0; $i < $fileCount; $i++) {
            $fileName = $file["name"][$i];
            $ext = pathinfo($file['name'][$i], PATHINFO_EXTENSION);

            if (!in_array($ext, $ext_permitidas)) continue;
            $new_file_name = md5($fileName . filesize($file["tmp_name"][$i]) . date('s i')) . "." . $ext;
            //var_dump($output_dir);
            //exit;
            move_uploaded_file($file["tmp_name"][$i], $output_dir . $new_file_name);
            array_push($arrayFilesName, $new_file_name);
        }
        return $arrayFilesName;
    } else return false;

}

function upload_foto($file, $folder)
{
    if (isset($file['name'][0]) && !empty($file['name'][0]) && $file['name'][0] != '') {
     
        $output_dir = BASE_PATH ."uploads/" .$folder."/";
     
        $fileName = $file["name"];
        $ext = pathinfo($file['name'], PATHINFO_EXTENSION);

        if($ext == "jpg" || $ext == "png" || $ext == "jpeg"){
            $new_file_name = md5($fileName . filesize($file["tmp_name"]) . date('s i')) . "." . $ext;
            move_uploaded_file($file["tmp_name"], $output_dir . $new_file_name);
            // copy($file["tmp_name"], $output_dir . $new_file_name);
            return $new_file_name;             
        }      

    } else return null;
}

function salvar_foto($file, $folder, $nome)
{
    $nome = remove_accents($nome);
    $nome = generateSeoURL($nome, 32);
    
    if (isset($file['name'][0]) && !empty($file['name'][0]) && $file['name'][0] != '') {
     
        $output_dir = BASE_PATH ."uploads/" .$folder."/";
     
        $ext = pathinfo($file['name'], PATHINFO_EXTENSION);

        if($ext == "jpg" || $ext == "png" || $ext == "jpeg" || $ext == "webp"){
            $new_file_name = $nome.'-'.md5(filesize($file["tmp_name"]) . date('s i')) . "." . $ext;
            move_uploaded_file($file["tmp_name"], $output_dir . $new_file_name);
            // copy($file["tmp_name"], $output_dir . $new_file_name);
            return $new_file_name;             
        }      

    } else return null;
}

function cara_exist_or_create($name)
{
    global $dataBase;
    $name = mysqli_real_escape_string($dataBase, $name);
    $sql = "SELECT * FROM tb_cara WHERE cara_nome = '$name'";
    $query = mysqli_query($dataBase, $sql);
    if ($query->num_rows) {
        return $query->fetch_object()->cara_id;
    }
    $dataBase->query("INSERT INTO tb_cara(cara_nome) VALUES('$name')");
    return mysqli_insert_id($dataBase);

}

function save_cara($id, $caras, $values, $delete = 0)
{
    global $dataBase;
    $t = count($caras);
    if ($delete) {
        //deletando categorais anteriores
        $sql = "DELETE FROM prod_has_cara WHERE fk_prod_id = $id";
        $dataBase->query($sql);
    }

    for ($i = 0; $i < $t; $i++) {
        $cara = cara_exist_or_create($caras[$i]);
        $value = trim(addslashes($values[$i]));
        if ($cara == '' || $value == '') continue;
        $sql = "INSERT INTO prod_has_cara(fk_prod_id, fk_cara_id, value) VALUES($id,$cara,'$value')";
        $dataBase->query($sql);
    }

}

function save_tags($id, $tags, $delete = 0)
{
    global $dataBase;
    $tags = explode(',', $tags);
//    die($tags);
    if ($delete) {
        //deletando categorais anteriores
        $sql = "DELETE FROM tb_filtro WHERE fk_prod_id = $id";
        $dataBase->query($sql);
    }

    foreach ($tags as $tag) {
        $tag = addslashes($tag);
        $sql = "INSERT INTO tb_filtro (fil_nome, fk_prod_id) VALUES('$tag','$id')";
        $dataBase->query($sql);
    }

}

function relate_photos($id, $photos, $delete = 0)
{
    global $dataBase;
    $photos = explode(';', $photos);

    if ($delete) {
        //deletando categorais anteriores
        $sql = "DELETE FROM tb_foto_produto WHERE fk_id = $id";
        $dataBase->query($sql);
    }

    foreach ($photos as $photo) {
        $photo = addslashes($photo);
        if ($photo == '' || !$photo) continue;
        //colocar marca d agua
//        write_img($photo);
        $sql = "INSERT INTO tb_foto_produto (foto, fk_id) VALUES('$photo','$id')";
        $dataBase->query($sql);
    }

}
function relate_photos_foto($pagina, $photos, $delete = 0)
{
    global $dataBase;
    $photos = explode(';', $photos);

    foreach ($photos as $photo) {
        $photo = addslashes($photo);
        if ($photo == '' || !$photo) continue;
     
        $sql = "INSERT INTO tb_foto (foto, pagina) VALUES('$photo','$pagina')";
        $dataBase->query($sql);
    }

}
function relate_photos_hotel($id, $photos, $delete = 0)
{
    global $dataBase;
    $photos = explode(';', $photos);

    if ($delete) {
        //deletando categorais anteriores
        $sql = "DELETE FROM tb_foto_hotel WHERE fk_hospedagem_id = $id";
        $dataBase->query($sql);
    }

    foreach ($photos as $photo) {
        $photo = addslashes($photo);
        if ($photo == '' || !$photo) continue;
        //colocar marca d agua
//        write_img($photo);
        $sql = "INSERT INTO tb_foto_hotel (foto, fk_hospedagem_id) VALUES('$photo','$id')";
        $dataBase->query($sql);
    }
}
function relate_photos_passeio($id, $photos, $delete = 0)
{
    global $dataBase;
    $photos = explode(';', $photos);

    if ($delete) {
        $sql = "DELETE FROM tb_foto_passeio WHERE fk_passeio_id = $id";
        $dataBase->query($sql);
    }

    foreach ($photos as $photo) {
        $photo = addslashes($photo);
        if ($photo == '' || !$photo) continue;
        $sql = "INSERT INTO tb_foto_passeio (foto, fk_passeio_id) VALUES('$photo','$id')";
        $dataBase->query($sql);
    }
}

function save_cat($id, $cats, $delete = 0)
{
    global $dataBase;
    if ($delete) {
        //deletando categorais anteriores
        $sql = "DELETE FROM prod_has_cat WHERE fk_prod_id = $id";
        $dataBase->query($sql);
    }

    foreach ($cats as $cat) {
        $cat = (int)($cat);
        $sql = "INSERT INTO prod_has_cat (fk_cat_id, fk_prod_id) VALUES('$cat','$id')";
        $dataBase->query($sql);
    }
}

function prod_have_photo($id)
{
    global $dataBase;
    $sql = "SELECT * FROM tb_foto_prod WHERE fk_prod_id = $id";
    $query = mysqli_query($dataBase, $sql);
    return $query->num_rows;
}

function get_prod_cat($id, $list = false, $filter = false)
{
    global $dataBase;
    $sql = "SELECT * FROM tb_categoria a JOIN prod_has_cat b ON a.id_cat = b.fk_cat_id WHERE b.fk_prod_id = $id";
    if ($filter) $sql .= " AND a.cat_is_menu=1";
    $query = mysqli_query($dataBase, $sql);
    $r = array();
    while ($row = mysqli_fetch_assoc($query)) {
        if ($list) $r[] = $row['id_cat'];
        else $r[] = $row;
    }

    return $r;
}

function get_event_imgs($id)
{
    global $dataBase;
    $sql = "SELECT * FROM tb_foto_evento WHERE fk_evento_id = '$id'";
    $query = mysqli_query($dataBase, $sql);
    $list = array();
    while ($row = mysqli_fetch_object($query)) $list[] = $row;
    return $list;
}
function get_hotel_imgs($id)
{
    global $dataBase;
    $sql = "SELECT * FROM tb_foto_hotel WHERE fk_hospedagem_id = '$id'";
    $query = mysqli_query($dataBase, $sql);
    $list = array();
    while ($row = mysqli_fetch_object($query)) $list[] = $row;
    return $list;
}
function get_imgs($id, $table)
{
    global $dataBase;
    $sql = "SELECT * FROM tb_foto_${table} WHERE fk_${table}_id = '$id'";
    $query = mysqli_query($dataBase, $sql);
    $list = array();
    while ($row = mysqli_fetch_object($query)) $list[] = $row;
    return $list;
}

function generate_image_link($path, $size_w = 600, $size_h = 500, $style = '')
{
    if (!$path) return '';
    $ext = explode('.', $path);
    $ext = end($ext);

    if($ext=='png') $path = site_url() . "thumb/phpThumb.php?" . "src=" . $path . "&w=$size_w&h=$size_h&zc=1&f=png";
    else $path = site_url() . "thumb/phpThumb.php?" . "src=" . $path . "&w=$size_w&h=$size_h&zc=1";
    return $path;
}


function delete_img_link($str, $table)
{
    global $dataBase;
    if ($str == '') return;
    $str = explode(',', $str);
    //var_dump($str);
    $t = count($str);
    //var_dump($str);

    if (!$t) return false;
    for ($i = 0; $i < $t; $i++) {
        $id = (int)$str[$i];

        $sql = "SELECT foto FROM tb_foto_${table} WHERE id = $id";
        $query = mysqli_query($dataBase, $sql);
        $r = mysqli_fetch_array($query);
        if ($r) {

            //deletando arquivo
            $name = $r['foto']; 

            $output_dir = BASE_PATH . "uploads/${table}/";
            unlink($output_dir . $name);
            //deeltenado do banco
            $sql = "DELETE FROM tb_foto_${table} WHERE id = $id";
            echo $dataBase->query($sql);

        }
    }
}
function delete_img_link_hotel($str)
{
    global $dataBase;
    if ($str == '') return;
    $str = explode(',', $str);
    //var_dump($str);
    $t = count($str);
    //var_dump($str);

    if (!$t) return false;
    for ($i = 0; $i < $t; $i++) {
        $id = (int)$str[$i];

        $sql = "SELECT foto FROM tb_foto_hotel WHERE id = $id";
        $query = mysqli_query($dataBase, $sql);
        $r = mysqli_fetch_array($query);
        if ($r) {

            //deletando arquivo
            $name = $r['foto']; 

            $output_dir = BASE_PATH . "uploads/hotel/";
            unlink($output_dir . $name);
            //deeltenado do banco
            $sql = "DELETE FROM tb_foto_hotel WHERE id = $id";
            echo $dataBase->query($sql);

        }
    }
}

function prod_belong_to_cat($id, $id_prod)
{
    global $dataBase;
    $sql = "SELECT * FROM tb_produtos a JOIN prod_has_cat b ON a.pro_id = b.fk_prod_id WHERE b.fk_cat_id = $id AND b.fk_prod_id = $id_prod";
    $query = mysqli_query($dataBase, $sql);
    return $query->num_rows;
}

function prod_belong_to_mar($id, $id_prod)
{
    global $dataBase;
    $sql = "SELECT * FROM tb_produtos WHERE pro_marca = $id AND pro_id = $id_prod";
    $query = mysqli_query($dataBase, $sql);
    return $query->num_rows;
}

function get_cat_desc_prod($id_prod)
{
    global $dataBase;
    $sql = "SELECT * FROM tb_cat a JOIN prod_has_cat b ON a.id_cat = b.fk_cat_id WHERE b.fk_prod_id = $id_prod AND cat_status = 1 LIMIT 1";
    $query = mysqli_query($dataBase, $sql);
    $r = false;
    while ($row = mysqli_fetch_object($query)) $r = $row->cat_nome;
    return $r;
}

function get_prods_by_cat($id, $order = 'nome-asc')
{
    global $dataBase;
    if(!$id || $id=='') return array();
    $order = ($order == 'nome-asc' || $order == 'nome-desc') ? 'prod_nome' : $order;
    $order = ($order == 'price-asc' || $order == 'price-desc') ? 'prod_preco' : $order;

    $sql = "SELECT c.* FROM tb_cat a JOIN prod_has_cat b ON a.id_cat = b.fk_cat_id JOIN tb_produto c ON c.prod_id = b.fk_prod_id WHERE a.id_cat = '$id' OR a.fk_cat_id = '$id' AND c.status = 1 GROUP BY c.prod_id ORDER BY $order";
    if (is_array($id)) {
        $id = implode(',', $id);
        $sql = "SELECT c.* FROM tb_cat a JOIN prod_has_cat b ON a.id_cat = b.fk_cat_id JOIN tb_produto c ON c.prod_id = b.fk_prod_id WHERE a.id_cat  IN ($id) AND c.status = 1";
    }
    echo $sql;
//    echo "<script>console.log('" . addslashes($sql) . "')</script>";
    $query = mysqli_query($dataBase, $sql);
    $r = array();
    while ($row = mysqli_fetch_object($query)) $r[] = $row;
    return $r;
}

function return_sql_string($entrys, $ord, $cat)
{
    //jujntado os campos
    $sql = array();
    if (!$entrys) $entrys = array();
    $keys = array_keys($entrys);
    $fields = array('cat' => 'c.fk_cat_id', 'marca' => 'fk_mar_id', 'price' => 'prod_preco');
    foreach ($keys as $key) {
        $str = array();
        if ($key == 'price') {

            foreach ($entrys[$key] as $price) {
                $vals = explode('-', $price);
                $str[] = "(" . $fields[$key] . ' BETWEEN "' . str_replace(',', '', $vals[0]) . '" AND "' . str_replace(',', '', $vals[1]) . '")';
            }
        } else if ($key == 'cara') {
            foreach ($entrys[$key] as $cara) {
                $str[] = "(b.fk_cara_id = " . $cara['key'] . " AND value = '" . $cara['val'] . "')";
            }
        } else if ($key == "cat") {

            foreach ($entrys[$key] as $val) {
                $str [] = $fields[$key] . " = " . (int)$val;
                $str [] = "d.fk_cat_id = " . (int)$val;
            }
        } else {
            foreach ($entrys[$key] as $val) {
                $str [] = $fields[$key] . " = " . (int)$val;
            }
        }
        $str = implode(" OR ", $str);
        $sql [] = "($str)";
    }
    if (count($sql)) {
        if ($ord == 'nome') $ord = "prod_nome ASC";
        if ($ord == 'price_asc') $ord = 'prod_preco ASC';
        if ($ord == 'price_desc') $ord = 'prod_preco DESC';
        $addon = '';
        if (!count($entrys['cat'])) $addon = " AND c.fk_cat_id= '$cat'";
        return " AND " . (implode(' AND ', $sql)) . "  $addon GROUP BY prod_id  ORDER BY estoque DESC,$ord";
    } else return '';

}

function get_cat_sons($id_cat, $grand = false)
{
    global $dataBase;
    if ($grand) $sql = "SELECT * FROM tb_cat WHERE fk_cat_id = $id_cat AND cat_status = 1 AND id_cat IN (SELECT fk_cat_id FROM prod_has_cat )";
    else $sql = "SELECT * FROM tb_cat WHERE fk_cat_id = $id_cat AND cat_status = 1";
//    die($sql);
    $query = mysqli_query($dataBase, $sql);
    $list = array();
    while ($row = mysqli_fetch_object($query)) {
        $list[] = $row;
    }

    return $list;
}

function get_cat_menu_sons($id_cat)
{
    global $dataBase;
    $sql = "SELECT * FROM tb_cat WHERE fk_cat_id = $id_cat AND cat_status = 1 AND cat_is_menu = 1  ";
//    die($sql);
    $query = mysqli_query($dataBase, $sql);
    $list = false;
    while ($row = mysqli_fetch_object($query)) {
        $list[] = $row;
    }

    return $list;
}

function is_image($path)
{
    $a = getimagesize($path);
    $image_type = $a[2];

    if (in_array($image_type, array(IMAGETYPE_GIF, IMAGETYPE_JPEG, IMAGETYPE_PNG, IMAGETYPE_BMP))) {
        return true;
    }
    return false;
}

function create_instace_img($img)
{
    $type = image_type_to_mime_type(exif_imagetype($img));
    switch ($type) {
        case 'image/gif':
            return imagecreatefromgif($img);
        case 'image/jpeg':
            return imagecreatefromjpeg($img);
        case 'image/png':
            return imagecreatefrompng($img);
        case 'image/bmp':
            return imagecreatefrombmp($img);
    }
    return false;
}

function save_instace_img($img, $dest)
{
//    unlink($dest);
//    return imagejpeg($img, $dest,100);

    $type = image_type_to_mime_type(exif_imagetype($dest));
    switch ($type) {
        case 'image/gif':
            return imagegif($img, $dest);
        case 'image/jpeg':
            return imagejpeg($img, $dest, 100);
        case 'image/png':
            return imagepng($img, $dest, 0);
        case 'image/bmp':
            return imagebmp($img, $dest, 0);
    }
    return false;
}

function write_img($img)
{
    ini_set("gd.jpeg_ignore_warning", 1);
    $base = path() . 'uploads/produto/';
    $path = $base . $img;
    if (!file_exists($path)) {
        die($path);
        echo 'Arquivo n existe' . PHP_EOL;
        return;
    }
    $mark = imagecreatefrompng(path() . 'assets/img/logo.fw.png');
    // Create Image From Existing File
    $img = create_instace_img($path);

    if (!$img) return;
    // Set the margins for the stamp and get the height/width of the stamp image
    $marge_right = 10;
    $marge_bottom = 10;
    $sy = imagesy($mark);

// Copy the stamp image onto our photo using the margin offsets and the photo
// width to calculate positioning of the stamp.
    imagecopy($img,
        $mark, 0 + $marge_right, imagesy($img) - $sy - $marge_bottom, 0, 0, imagesx($mark), imagesy($mark));
  
    save_instace_img($img, $path);
    imagedestroy($img);
}

function get_cat_num_prod($id)
{
    global $dataBase;
    $sql = "SELECT COUNT(*) AS total FROM prod_has_cat a JOIN tb_cat b ON a.fk_cat_id = b.id_cat WHERE a.fk_cat_id = $id  OR b.fk_cat_id = $id";
    $query = mysqli_query($dataBase, $sql);
    return $query->fetch_object()->total;
}

function get_marca_num_prod($id, $cat)
{
    global $dataBase;
    $sql = "SELECT COUNT(*) AS total FROM tb_produto a JOIN prod_has_cat b ON a.prod_id = b.fk_prod_id WHERE fk_mar_id = $id AND fk_cat_id = $cat";
//    die($sql);
    $query = mysqli_query($dataBase, $sql);
    return $query->fetch_object()->total;
}

function get_cara_values($cara, $cat)
{
    global $dataBase;
    $sql = "SELECT * FROM prod_has_cara a JOIN tb_produto b ON a.fk_prod_id = b.prod_id JOIN prod_has_cat c ON b.prod_id = c.fk_prod_id WHERE fk_cara_id = $cara AND fk_cat_id = $cat  GROUP BY value";
    $query = mysqli_query($dataBase, $sql);
    $r = array();
    while ($row = $query->fetch_object()) $r[] = $row;
    return $r;
}

function get_value_num_prod($id, $cat)
{
    global $dataBase;
    $sql = "SELECT COUNT(*) AS total FROM prod_has_cara a JOIN tb_produto b ON a.fk_prod_id = b.prod_id JOIN prod_has_cat c ON b.prod_id = c.fk_prod_id  WHERE `value` = '$id' AND fk_cat_id = $cat";
//    die($sql);
    $query = mysqli_query($dataBase, $sql);
    return $query->fetch_object()->total;
}

function router()
{
    global $route;
    $base = str_replace(site_url(), '', (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]");;
    $base_e = explode('/', $base);
    if (strpos($base, '.php') !== false) {
        view($base);
        return;
    }

    if (isset($route[$base]) && function_exists($route[$base])) {
        $route[$base]();
        return;
    } else if (!isset($route['%s']) && count($base_e) == 1) {
        $vars = (route_parse($route, $base));
        $base = explode('/', $base);
        if (count($base) == 1) {
            $route['%s']($vars);
            return;
        }
    } else {
        $vars = (route_parse($route, $base));
        if ($vars && function_exists($route[$vars['route']])) {
            $route[$vars['route']]($vars['vars']);
        }
    }

}

function route_parse($route, $base)
{
    $keys = array_keys($route);
    $params = explode("/", $base);
    $vars = array();
    $aux = false;

    foreach ($keys as $key) {
        foreach ($params as $param) {
            if (sprintf($key, $param) == $base) {
                $aux = true;
                $vars = $param;
            }
        }
        if ($aux) {
            $info = array('route' => $key, 'vars' => $vars);
            return $info;
        }
    }
}


function view($view, $var = array())
{
    global $dataBase;
    extract($var);
    $php_extension = $view . '.php';
//    echo '<br> incluindo '.$view;
//    return;
    if (file_exists(BASE_PATH . $view)) {
        include BASE_PATH . $view;
        return true;
    } else if (file_exists(BASE_PATH . $php_extension)) include BASE_PATH . $php_extension;
    else echo "view não encontrada";
}

function is_mobile()
{

    $useragent = $_SERVER['HTTP_USER_AGENT'];

    return (preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i', $useragent) || preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i', substr($useragent, 0, 4)));
}


function get_prod_by_esp($id)
{
    global $dataBase;
    $sql = "SELECT * FROM especial_has_cat WHERE fk_esp_id = $id";
//    die($sql);
    $query = mysqli_query($dataBase, $sql);
    $list = array();
    while ($row = mysqli_fetch_object($query)) {
        $list[] = $row->fk_cat_id;
    }
    if (!count($list)) return array();
    $list = get_prods_by_cat($list);

    return $list;
}

function get_estereo($id)
{
    global $dataBase;
    $sql = "SELECT a.* FROM tb_cat a WHERE a.cat_status = 1 AND fk_cat_id = '$id' AND id_cat NOT IN (SELECT fk_cat_id FROM tb_cat) AND id_cat IN (SELECT fk_cat_id FROM prod_has_cat) ORDER BY cat_nome ASC";
//    die($sql);
    $query = mysqli_query($dataBase, $sql);
    $list = array();
    while ($row = mysqli_fetch_object($query)) {
        $list[] = $row;
    }

    return $list;
}

function get_prod_marca($id)
{
    global $dataBase;
    $sql = "SELECT * FROM tb_produtos a JOIN tb_marca b ON a.pro_marca = b.mar_id WHERE pro_id = '$id'";
    $query = mysqli_query($dataBase, $sql);
    if (!$query) return false;
    return mysqli_fetch_object($query)->mar_nome;
}

function get_prod_categoria($id){
    global $dataBase;
    $id = (int) $id;

    $sql = "SELECT cat_nome FROM tb_categoria WHERE cat_id = $id";
    $query = mysqli_query($dataBase,$sql);
    $object = mysqli_fetch_object($query);

    return $object->cat_nome;
}

function smtpmailer($para, $assunto, $corpo, $att = false)
{
    $de = "contato@magnumcomunicacao.com.py";
    $de_nome = "Contato - Magnum Comunicação";
    $senha = "zsNDyr24Z6RvDhL";
    $mail = new PHPMailer();

    $mail->IsSMTP();
    $mail->SMTPDebug = 1;
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = '';
    $mail->Host = 'smtp.magnumcomunicacao.com.py';

    $mail->Port = 587;
    $mail->Username = $de;
    $mail->Password = $senha;
    $mail->IsHTML(true);
    $mail->CharSet = 'UTF-8';
    if ($att) {
        try {
            $mail->AddAttachment($att);
        } catch (phpmailerException $e) {
            echo "ERROR $e";
        }
    }
    try {
        $mail->SetFrom($de, $de_nome);
    } catch (phpmailerException $e) {
    }
    $mail->Subject = $assunto;
    $mail->Body = $corpo;
    $mail->AddAddress($para);
    return $mail->Send();

}

function get_video_id($url)
{
    parse_str(parse_url($url, PHP_URL_QUERY), $r);
    return $r['v'];
}

function get_config($name)
{
    global $dataBase;
    $sql = "SELECT * FROM tb_config WHERE conf_name = '$name'";
    $query = mysqli_query($dataBase, $sql);
    if ($query->num_rows) {
        return $query->fetch_object()->conf_value;
    }
    return false;
}

function get_menu_tree()
{
    global $dataBase;
    $sql = "SELECT men_id as id, men_nome as text, IF(fk_men_id=0, '#', fk_men_id) as parent, men_status as status FROM tb_menu";
    $query = mysqli_query($dataBase, $sql);
    $data = array();
    while ($row = mysqli_fetch_assoc($query)) $data[] = $row;
    return $data;
}

function render_script_string($list, $type)
{
    if (!count($list) || !isset($list[$type])) return '';

    if ($type == 'js') $base = "<script src='%s' type='text/javascript'></script>";
    if ($type == 'css') $base = "<link rel='stylesheet' type='text/css' href='%s'>";
    if ($type == 'tags') $base = "<meta property='og:%s' content='%s'>";
    $append = '';
    foreach ($list[$type] as $item) {
        if ($type == 'tags') {
            $keys = array_keys($item);
            foreach ($keys as $key) {
                $append .= sprintf($base, $key, $item[$key]) . "\n";
            }
        } else $append .= sprintf($base, $item) . "\n";
    }

    return $append;
}

function get_header($loads = array())
{
    global $dataBase;
    $js = render_script_string($loads, 'js');
    $css = render_script_string($loads, 'css');
    $tags = render_script_string($loads, 'tags');;

    require_once path('base/header.php');
}

function prod_generator($row, $img, $col = 60, $desconto = false, $cat = true)
{
    if ($desconto) {
        if ($row->prod_preco_desconto != '' && $row->prod_preco_desconto > 0) {
            $row->prod_preco = $row->prod_preco_desconto;
        }
    }

    ?>
    <div class="large-<?php echo $col ?> small-60 prod-container">
        <div class="prod">
            <a href="<?php echo site_url('produto/' . $row->url) ?>">
                <div class="grid-x">
                    <?php if ($cat): ?>
                        <div class="cell cat-prod">
                            <?php echo @get_prod_cat($row->prod_id)[0]['cat_nome']; ?>
                        </div>
                    <?php endif; ?>
                    <div class="cell img-prod">
                        <img src="<?php echo $img; ?>">
                    </div>
                    <div class="cell name-prod">
                        <?php echo $row->prod_nome; ?>
                    </div>
                    <div class="cell price-prod">
                        <div class="grid-x">
                            <div class="large-30 new text-left">
                                <span class="moeda">US$</span><?php echo $row->prod_preco; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>
    <?php
}

function displayMaxCaractersForText($text, $limit = 40) {
    return strlen($text) > $limit ? substr($text, 0, $limit)."..." : $text;
}

function write_log($e,$id_el,$type){
    global $dataBase;
    $types = array('INSERT', 'EDIT', 'DELETE', 'ACCESS', 'ERROR', 'UPDATE');
    $el = array('BANNER', 'MARCA', 'CATEGORIA', 'PRODUTO');

    if(!in_array($type,$types)) echo 'Tipo de log desconhecido';
    if(!in_array($e,$el)) echo 'Tipo de log desconhecido';

    $ip = $_SERVER["REMOTE_ADDR"];
    $id = $_SESSION['usu_id'];
    $link = $_SERVER['REQUEST_URI'];

    $sql = "INSERT INTO tb_log(log_type,log_link,log_usu_id,log_ip,log_el,log_el_id) VALUES('$type','$link','$id','$ip','$e','$id_el')";

    return $dataBase->query($sql);
}

function salvar_imagem_no_disco($arquivo, $diretorio) {
    if ($arquivo['error'] != 4 && !empty($arquivo['name']) && $arquivo['name'] != '') {
     
        $diretorio_final = BASE_PATH ."uploads/" .$diretorio."/";
     
        $nome_original = $arquivo["name"];
        $tmp_arquivo = $arquivo["tmp_name"];
        $extensao = pathinfo($nome_original, PATHINFO_EXTENSION);

        if ($extensao == "jpg" || $extensao == "png" || $extensao == "jpeg") {
            
            $nova_nomenclatura = md5($nome_original . filesize($tmp_arquivo) . date('s i'));
            
            $nome_modificado = $nova_nomenclatura.".".$extensao;
            $caminho_arquivo = $diretorio_final.$nome_modificado;

            if (move_uploaded_file($tmp_arquivo, $caminho_arquivo)) {
                $arquivo_webp = $nova_nomenclatura.".webp";
                
                if ($extensao == "jpg" || $extensao == "jpeg") $imagem_instancia = imagecreatefromjpeg($diretorio_final.$nome_modificado);
                else $imagem_instancia = imagecreatefrompng($diretorio_final.$nome_modificado);
    
                $conversor_webp = imagewebp(
                    $imagem_instancia, 
                    $diretorio_final.$arquivo_webp,
                    95
                );
            
                if ($conversor_webp) {
                    imagedestroy($imagem_instancia);

                    return $arquivo_webp;
                }
            }

            return $nome_modificado;             
        }      

    } else return null;
}

function upload_arquivo($arquivo, $diretorio) {
    if ($arquivo['error'] != 4 && !empty($arquivo['name']) && $arquivo['name'] != '') {
     
        $diretorio_final = BASE_PATH ."uploads/" .$diretorio."/";
     
        $nome_original = $arquivo["name"];
        $tmp_arquivo = $arquivo["tmp_name"];
        $extensao = pathinfo($nome_original, PATHINFO_EXTENSION);
            
        $nova_nomenclatura = md5($nome_original . filesize($tmp_arquivo) . date('s i'));
        
        $nome_modificado = $nova_nomenclatura.".".$extensao;
        $caminho_arquivo = $diretorio_final.$nome_modificado;

        return (move_uploaded_file($tmp_arquivo, $caminho_arquivo)) ? $nome_modificado : null;   
        
    } else return null;
}