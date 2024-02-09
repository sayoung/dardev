<?php
if (!class_exists("element_drv_our_story.php")):
    class element_drv_our_story
    {
        public function render_form()
        {
            $fields = [
                "type" => "element_drv_our_story.php",
                "title" => t("Our Story"),
                "fields" => [
                    [
                        "id" => "title",
                        "type" => "text",
                        "title" => t("Title"),
                    ],
                    [
                        "id" => "sub_title",
                        "type" => "text",
                        "title" => t("Sub title"),
                        "admin" => true,
                    ],
                    [
                        "id" => "link_title",
                        "type" => "text",
                        "title" => t("Title of lien"),
                        
                    ],
                    [
                        "id" => "link",
                        "type" => "text",
                        "title" => t("lien"),
                        
                    ],
                    [
                        "id" => "motif_1",
                        "type" => "upload",
                        "title" => t("motif 1"),
                    ],
                    [
                        "id" => "image",
                        "type" => "upload",
                        "title" => t("Image"),
                    ],
                    [
                        "id" => "motif_2",
                        "type" => "upload",
                        "title" => t("motif 2"),
                    ],
                    [
                        "id" => "style",
                        "type" => "select",
                        "title" => t("Style"),
                        "options" => [
                            "skin-white" => "Background White",
                            "skin-dark" => "Background Dark",
                            "skin-white-border" => "Background White Border",
                        ],
                    ],
                    [
                        "id" => "animate",
                        "type" => "select",
                        "title" => t("Animation"),
                        "desc" => t("Entrance animation for element"),
                        "options" => dardev_content_builder_animate(),
                        "class" => "width-1-2",
                    ],
                    [
                        "id" => "animate_delay",
                        "type" => "select",
                        "title" => t("Animation Delay"),
                        "options" => dardev_content_builder_delay_wow(),
                        "desc" => "0 = default",
                        "class" => "width-1-2",
                    ],
                    [
                        "id" => "el_class",
                        "type" => "text",
                        "title" => t("Extra class name"),
                        "desc" => t(
                            "Style particular content element differently - add a class name and refer to it in custom CSS."
                        ),
                    ],
                ],
            ];
            for ($i = 1; $i <= 2; $i++) {
                $fields['fields'][] = array(
                    'id'     => "info_{$i}",
                    'type'   => 'info',
                    'desc'   => "Information for item {$i}"
                 );
                $fields["fields"][] = [
                    "id" => "title_{$i}",
                    "type" => "text",
                    "title" => t("Title {$i}"),
                ];
                $fields["fields"][] = [
                    "id" => "content_{$i}",
                    "type" => "textarea_without_html",
                    "title" => t("Content {$i}"),
                ];
            }
            return $fields;
        }

        public static function render_content($attr = [], $content = "")
        {
            $default = [
                "title" => "",
                "sub_title" => "",
                "image" => "",
                "link_title"=> "",
                "link"=> "",
                "motif_1"=> "",
                "motif_2"=> "",
                "style" => "",
                "animate" => "",
                "animate_delay" => "",
                "el_class" => "",
            ];
            for ($i = 1; $i <= 10; $i++) {
                $default["title_{$i}"] = "";
                $default["image_{$i}"] = "";
                $default["content_{$i}"] = "";
            }
            extract(dardev_merge_atts($default, $attr));

            $_id = "accordion-" . dardev_content_builder_makeid();
            $classes = $style;

            if ($el_class) {
                $classes .= " " . $el_class;
            }

            if ($animate) {
                $classes .= " wow " . $animate;
            }
            ob_start();
            ?>
                        <div class="row"> 
                            <div class="row mb-60 mb-xs-30">
                                
                                <div class="col-md-6">
                                    <h2 class="section-caption mb-xs-10"><?php print $sub_title; ?></h2>
                                    <h3 class="section-title mb-0"><span class="wow charsAnimIn" data-splitting="chars"><?php print $title; ?></span></h3>
                                </div>
                                
                                <div class="col-md-5 offset-md-1 relative text-start text-md-end pt-40 pt-sm-20 local-scroll">
                                    
                                    <!-- Decorative Dots -->
                                    <div class="decoration-2 d-none d-md-block" data-rellax-y data-rellax-speed="0.7" data-rellax-percentage="-0.2">
                                        <img src="<?php print $motif_2; ?>" alt="" />
                                    </div>
                                    <!-- End Decorative Dots -->
                                    
                                    <a href="<?php print $link; ?>" class="link-hover-anim underline align-middle" data-link-animate="y"><?php print $link_title; ?> <i class="mi-arrow-right size-18"></i></a>
                                    
                                </div>
                                
                            </div>
                            <div class="row wow fadeInUp" data-wow-delay="0.5s">
                            
                                <div class="col-lg-6 mb-md-60">
                                    <div class="position-relative">
                                        
                                        <!-- Image -->
                                        <div class="position-relative overflow-hidden">
                                            <img src="<?php print $image; ?>" class="image-fullwidth relative" alt="<?php print $title; ?>" />
                                        </div>
                                        <!-- End Image -->
                                        
                                        <!-- Decorative Waves -->
                                        <div class="decoration-1 d-none d-sm-block" data-rellax-y data-rellax-speed="1" data-rellax-percentage="0.1">
                                            <img src="<?php print $motif_1; ?>" alt="" />
                                        </div>
                                        <!-- End Decorative Waves -->
                                        
                                    </div>
                                </div>
                            
                                <div class="col-lg-6 col-xl-5 offset-xl-1">
                                    <?php for($i=1; $i<=10; $i++){ ?>
                                    <?php 
                                        $title = "title_{$i}";
                                        $content = "content_{$i}";
                                    ?>
                                    <h4 class="h5"><?php print $$title ?></h4>
                                    
                                    <p class="text-gray">
                                    <?php print $$content ?>
                                    </p>
                                    <?php } ?> 
                                    
                                    
                                </div>
                            
                            </div>   
                        </div>
                            
                            
        <?php return ob_get_clean(); ?>
     <?php
        }
    }
endif;
