<?php
session_start();
ob_start();
include('control.php');
if (isset($_GET['type'])) {
    extract($_GET);


    if ($type == 'signup') {
        $pro->SignUp($name, $email, $phone, $password);
    }

    if ($type == 'login') {
        $pro->LogIn($email, $password);
    }

    if ($type == 'contact') {
        $id = $_SESSION['id'];
        $user = [];
        $sql = $db->query("SELECT * FROM users WHERE id != '$id' ORDER BY updated_at DESC ");
        while ($row = mysqli_fetch_assoc($sql)) {
            $id = $row['id'];
            $lastchat = $pro->lastChat($id);
            $contact = $pro->myContact();
            $time = date('h:i A', $row['updated_at']);
            if (in_array($id, $contact)) {
                $user[] = ['id' => $id, 'email' => $lastchat, 'picture' => $row['picture'], 'name' => $row['name'], 'time' => $time];
            }
        }
        echo json_encode($user);
    }


    if ($type == 'chat') {
        $_SESSION['id2'] = $id2;
        $id = $_SESSION['id'];
        $type = $pro->userName($id2, 'member');
        $rows = array();
        $sql = $type == 0 ? $db->query("SELECT * FROM chat WHERE (id='$id' AND id2='$id2') OR (id='$id2' AND id2='$id') ") : $db->query("SELECT * FROM chat WHERE id2='$id2' ");
        while ($row = mysqli_fetch_assoc($sql)) {
            $chat = $id == $row['id'] ? $row['chat'] : $pro->userName($row['id']) . ': ' . $row['chat'];
            $rows[] = $type == 0 ? $row : ['id' => $row['id'], 'id2' => $row['id2'], 'chat' => $chat];
        }
        echo json_encode($rows);
    }

    if ($type == 'chatnew') {
        $_SESSION['id2'] = $id2;
        $id = $_SESSION['id'];
        $type = $pro->userName($id2, 'member');
        $rows = array();
        $sql = $type == 0 ? $db->query("SELECT * FROM chat WHERE (id='$id' AND id2='$id2') OR (id='$id2' AND id2='$id') AND status=0 ") : $db->query("SELECT * FROM chat WHERE id2='$id2' AND status=0 ");
        while ($row = mysqli_fetch_assoc($sql)) {
            $sn = $row['sn'];
            if ($id != $row['id']) {
                $db->query("UPDATE chat SET status=1 WHERE sn='$sn' ");
            }
            $chat = $id == $row['id'] ? $row['chat'] : $pro->userName($row['id']) . ': ' . $row['chat'];
            $rows[] = $type == 0 ? $row : ['id' => $row['id'], 'id2' => $row['id2'], 'chat' => $chat];
        }
        echo json_encode($rows);
    }


    if ($type == 'newchat') {
        $pro->AddChat($chat);
    }


    if ($type == 'myid') {
        echo $_SESSION['id'];
    }

    if ($type == 'addcontact') {
        echo $pro->addContact($email);
    }
}
