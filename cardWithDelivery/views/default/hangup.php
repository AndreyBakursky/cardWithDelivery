<?php

use app\models\Calls;
use yii\web\View;

/* @var $this View */
/* @var $call Calls */
?>

<div class="wrap">
    <div class="container offset">
        <div class="row">
            <div class= "col-lg-12">
                <table class="table table-bordered">
                    <tbody>
                    <tr>
                        <th scope="col">ID Контакта</th>
                        <td><?= $call->getFidContact() ?></td>
                    </tr>
                    <tr>
                        <th scope="col">Результат звонка</th>
                        <td><?= $call->getFidResult() ?></td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
