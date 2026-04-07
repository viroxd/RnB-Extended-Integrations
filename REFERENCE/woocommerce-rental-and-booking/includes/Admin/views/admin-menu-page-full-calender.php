<?php 
$colors = rnb_get_status_to_color_map();
$wo_status = wc_get_order_statuses();
?>
<h3><?php esc_html_e('Color codes:', 'redq-rental') ?> </h3>
<ul class="status-colors">
    <?php foreach ($colors as $status => $color) : ?>
        <li class="status-color" style="background-color: <?php echo $color; ?>">
            <span class="status-name">
                <?php
                    $get_status = 'wc-'.$status;
                    $status_text = isset($wo_status[$get_status]) ? $wo_status[$get_status]: ucfirst($status); 
                    echo esc_html($status_text);
                ?>
            </span>
        </li>
    <?php endforeach; ?>
</ul>

<div class="wrap">
    <div id="redq-rental-calendar"></div>
</div>

<div id="loader" class="lds-dual-ring hidden overlay"></div>

<div id="eventContent" class="popup-modal white-popup-block mfp-hide">
    <div class="white-popup">
        <h2><a id="eventProduct" href="" target="_blank"></a></h2>
        <div id="eventInfo"></div>
        <p>
            <strong>
                <a id="eventLink" href="" target="_blank"><?php esc_html_e('View Order', 'redq-rental') ?></a>
            </strong>
        </p>
    </div>
</div>

<style>
    #redq-rental-calendar {
        background: #ececec;
    }

    .lds-dual-ring.hidden {
        display: none;
    }

    .lds-dual-ring {
        display: inline-block;
        width: 80px;
        height: 80px;
    }

    .lds-dual-ring:after {
        content: " ";
        display: block;
        width: 64px;
        height: 64px;
        margin: 22% auto;
        border-radius: 50%;
        border: 6px solid #fff;
        border-color: #fff transparent #fff transparent;
        animation: lds-dual-ring 1.2s linear infinite;
    }

    @keyframes lds-dual-ring {
        0% {
            transform: rotate(0deg);
        }
        100% {
            transform: rotate(360deg);
        }
    }
    .overlay {
        position: fixed;
        top: 20px;
        left: 0;
        width: 100%;
        height: 100vh;
        background: rgba(0, 0, 0, .8);
        z-index: 999;
        opacity: 1;
        transition: all 0.5s;
    }
</style>