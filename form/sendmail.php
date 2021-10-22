<?php
    if (mb_send_mail("yuma.saki0527@gmail.com", "テスト", "本文テスト")) {
        //送信成功
        echo "送信成功";
    } else {
        //送信失敗
        echo "送信失敗";
    }
?>