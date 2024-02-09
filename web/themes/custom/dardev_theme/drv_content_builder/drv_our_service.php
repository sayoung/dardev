<?php
if (!class_exists("element_drv_our_service")):
    class element_drv_our_service
    {
        public function render_form()
        {
            $fields = [
                "type" => "element_our_service",
                "title" => t("Our Service"),
                "fields" => [
                    [
                        "id" => "title",
                        "type" => "text",
                        "title" => t("Title"),
                        "admin" => true,
                    ],
                    [
                        "id" => "sub_title",
                        "type" => "text",
                        "title" => t("Sub title"),
                        "admin" => true,
                    ],
                    [
                        "id" => "description",
                        "type" => "text",
                        "title" => t("Description"),
                        "admin" => true,
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
            for ($i = 1; $i <= 10; $i++) {
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
                $fields["fields"][] = [
                    "id" => "image_{$i}",
                    "type" => "upload",
                    "desc" => "Photo for item {$i}",
                ];
            }
            return $fields;
        }

        public static function render_content($attr = [], $content = "")
        {
            $default = [
                "title" => "",
                "sub_title" => "",
                "description" => "",
                "description" => "",
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
                            <div class="col-lg-6 mb-md-60 mb-sm-30">
                                
                                <h2 class="section-caption mb-xs-10"><?php print $sub_title; ?></h2>
                                <h3 class="section-title mb-30"><span class="wow charsAnimIn" data-splitting="chars"><?php print $title; ?></span></h3>
                                
                                <div class="row">
                                    <div class="col-lg-10">
                                        <p class="section-descr mb-50 mb-sm-30 wow fadeInUp" data-wow-delay="0.4s">
                                        <?php print $description; ?> 
                                        </p>
                                    </div>
                                </div>
                                
                                <ul class="nav nav-tabs services-tabs wow fadeInUp" data-wow-delay="0.55s" role="tablist">
                                
                                 <?php for($i=1; $i<=10; $i++){ ?>
                                   <?php 
                                      $title = "title_{$i}";
                                      $content = "content_{$i}";
                                      $image = "image_{$i}";
                                   ?>
                                    
                                    <?php if($$title){ ?>	
                                    <li role="presentation">
                                        <a href="#services-item-<?php print $i ?>" <?php if($i==1){ ?>class="active"<?php }  ?> aria-controls="services-item-<?php print $i ?>" role="tab" aria-selected="true" data-bs-toggle="tab"><?php print $$title ?> <span class="number">0<?php print $i ?></span></a>
                                    </li>
                                    <?php }  ?>   
                                    <?php } ?>
                                </ul>                                
                                
                            </div>
                            <div class="col-lg-6 d-flex wow fadeInLeft" data-wow-delay="0.55s" data-wow-offset="275">
                                
                                <div class="tab-content services-content">
                                    <?php for($i=1; $i<=10; $i++){ ?>
                                        <?php 
                                            $title = "title_{$i}";
                                            $content = "content_{$i}";
                                            $image = "image_{$i}";
                                        ?>
                                        <?php if($$title){ ?>	
                                            <div class="tab-pane services-content-item show fade <?php if($i==1){ ?>active<?php }  ?>" id="services-item-<?php print $i ?>" role="tabpanel">
                                                
                                                <div class="services-text">
                                                    <div class="services-text-container">
                                                        <h4 class="services-title"><?php print $$title ?></h4>
                                                        <p class="text-gray mb-0">
                                                            <?php print $$content ?>
                                                        </p>
                                                    </div>
                                                </div>
                                                
                                                <img class="services-image" src="<?php print $$image ?>" alt="<?php print $$title ?>" />
                                                
                                            </div>
                                        <?php }  ?> 
                                    <?php } ?> 
                                </div>
                            </div>
                        </div>
                            
                            
        <?php return ob_get_clean(); ?>
     <?php
        }
    }
endif;
