<?php

if (!defined('JCSS_PLUGIN_DIR')) {
	header('HTTP/1.1 403 Forbidden', true, 403);
	exit;
}

function jcss_social_buttons() {
    
    $options = jcss_get_buttons_options();
    $advanced = jcss_get_advanced_options();
    
    $title = urlencode(html_entity_decode(get_the_title()));
    $url = get_permalink();
    
    $image = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'medium' ); 
    if (!$image) $image = urlencode('https://upload.wikimedia.org/wikipedia/commons/0/08/Pinterest-logo.png');
    else $image = $image[0];

    $socials =  explode(',', $options['social_options']);
    $twitter_username = $options['twitter_username']; 

    ob_start();
    ?>
       
    <div id = "jcss-social-buttons">
        <?php
        if (!empty($options['sharing_text']) && !empty($options['sharing_text_position']) && $options['sharing_text_position']==="above") {
            echo jcss_get_sharing_text($options, "jcss-above-buttons");
        }
        ?>    
        <div id = "jcss-buttons-container">
        <?php 
        if (!empty($options['sharing_text']) && !empty($options['sharing_text_position']) && $options['sharing_text_position']==="left") {
            echo jcss_get_sharing_text($options, "jcss-left-buttons");
        } 
        foreach ($socials as $social) {
            switch ($social) {
                case "Buffer": ?>
                    <a id="jcss-buffer" rel="external nofollow" class="jcss-button" href="https://bufferapp.com/add?text=<?php echo $title; ?>&url=<?php echo $url; ?>" target="_blank" >
                        <i class="<?php echo jcss_get_fa_classnames($advanced, 'buffer'); ?>"></i>
                        <?php jcss_get_social_name($options, $social);  ?>
                    </a>  <?php
                break;
                case "Email": ?>
                    <a id="jcss-email" rel="external nofollow" class="jcss-button jcss-email" href="mailto:?subject=<?php echo $title; ?>&body=<?php echo $url ?>" target="_blank" >
                        <i class="<?php echo jcss_get_fa_classnames($advanced, 'email'); ?>"></i>
                        <?php jcss_get_social_name($options, $social); ?>
                    </a>  <?php
                break; 
                case "Facebook": ?>
                    <a id="jcss-facebook" rel="external nofollow" class="jcss-button" href="http://www.facebook.com/sharer.php?u=<?php echo $url; ?>" target="_blank" >
                        <i class="<?php echo jcss_get_fa_classnames($advanced, 'facebook'); ?>"></i>
                        <?php jcss_get_social_name($options, $social); ?>
                    </a>  <?php
                break; 
                case "LinkedIn": ?>
                    <a id="jcss-linkedin" rel="external nofollow" class="jcss-button" href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo $url; ?>&title=<?php echo $title; ?>" target="_blank" >
                        <i class="<?php echo jcss_get_fa_classnames($advanced, 'linkedin'); ?>"></i>
                        <?php jcss_get_social_name($options, $social);  ?>
                    </a>  <?php
                break;
                case "Pinterest": ?>
                    <a id="jcss-pinterest" rel="external nofollow" class="jcss-button" href="http://pinterest.com/pin/create/button/?url=<?php echo $url; ?>&media=<?php echo $image; ?>&description=<?php echo $title; ?>" target="_blank" >
                        <i class="<?php echo jcss_get_fa_classnames($advanced, 'pinterest'); ?>"></i>
                        <?php jcss_get_social_name($options, $social);  ?>
                    </a>  <?php
                break;
                case "Reddit": ?>
                    <a id="jcss-reddit" rel="external nofollow" class="jcss-button" href="https://www.reddit.com/submit?url=<?php echo $url; ?>&title=<?php echo $title; ?>" target="_blank" >
                        <i class="<?php echo jcss_get_fa_classnames($advanced, 'reddit'); ?>"></i>
                        <?php jcss_get_social_name($options, $social); ?>
                    </a>  <?php
                break; 
                case "Telegram": ?>
                    <a id="jcss-telegram" rel="external nofollow" class="jcss-button" href="https://telegram.me/share/url?url=<?php echo $url; ?>&text=<?php echo $title; ?>" target="_blank" >
                        <i class="<?php echo jcss_get_fa_classnames($advanced, 'telegram'); ?>"></i>
                        <?php jcss_get_social_name($options, $social);  ?>
                    </a>  <?php
                break;
                case "Twitter": ?>
                    <a id="jcss-twitter" rel="external nofollow" class="jcss-button" href="http://twitter.com/intent/tweet/?text=<?php echo $title; ?>&url=<?php echo $url; if(!empty($twitter_username)) { echo '&via=' . $twitter_username; } ?>" target="_blank" >
                        <i class="<?php echo jcss_get_fa_classnames($advanced, 'twitter'); ?>"></i>    
                        <?php jcss_get_social_name($options, $social); ?>
                    </a>  <?php
                break;
                case "WhatsApp": ?>
                    <a id="jcss-whatsapp" rel="external nofollow" class="jcss-button" href="https://api.whatsapp.com/send?text=<?php echo $title.'–'.$url ?>" target="_blank" >
                        <i class="<?php echo jcss_get_fa_classnames($advanced, 'whatsapp'); ?>"></i>
                        <?php jcss_get_social_name($options, $social); ?>
                    </a>  <?php
                break;                
            } 
        }  ?>
        </div>
        <?php echo jcss_set_animation($advanced); ?>
    </div>
    <?php
    $html = ob_get_contents();
    ob_end_clean();
        
    return $html;
} 

function jcss_set_animation($advanced) {
    $animation = jcss_get_animation_options();
    $style_icon = sprintf('#jcss-buttons-container a:hover %3$s {animation: %1$s %2$s linear; }', $animation['animation'], $animation['duration'], $advanced['fa4'] === 'on' ? '.fa' : '.fab');
    $style = sprintf('<style> 
        %1$s 
        @keyframes fade {
            from {opacity:0;}
            to {opacity:1;}
        }
        @keyframes spin {
            from {transform:rotate(0deg);}
            to {transform:rotate(360deg);}
        }
        @keyframes slide {
            from { transform: translateX(-15px); }
            to { transform: translateX(0px); }
        }
        @keyframes bounce {
            from { transform: translateY(-5px); }
            to { transform: translateY(5px); }
        }
    </style>', $style_icon ) ;
    return $animation['play'] ? $style : '';
}