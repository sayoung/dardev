<?php
if (!class_exists("element_drv_our_service_style_2")):
    class element_drv_our_service_style_2
    {
        public function render_form()
        {
            $fields = [
                "type" => "element_our_service_style_2",
                "title" => t("Our Service Style 2"),
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
                    "id" => "icon_{$i}",
                    "type" => "text",
                    "desc" => "Icon svg ou fontawsome {$i}",
                ];
                $fields["fields"][] = [
                    "id" => "mini_descr_{$i}",
                    "type" => "text",
                    "desc" => "Grand title {$i}",
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
                "description" => "",
                "description" => "",
                "style" => "",
                "animate" => "",
                "animate_delay" => "",
                "el_class" => "",
            ];
            for ($i = 1; $i <= 10; $i++) {
                $default["title_{$i}"] = "";
                $default["icon_{$i}"] = "";
                $default["mini_descr_{$i}"] = "";
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
                            <div class="col-lg-12 mb-md-60 mb-sm-30">
                                
                                <h2 class="section-caption mb-xs-10"><?php print $sub_title; ?></h2>
                                <h3 class="section-title mb-30"><span class="wow charsAnimIn" data-splitting="chars"><?php print $title; ?></span></h3>
                                
                                <div class="row">
                                    <div class="col-lg-10">
                                        <p class="section-descr mb-50 mb-sm-30 wow fadeInUp" data-wow-delay="0.4s">
                                        <?php print $description; ?> 
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="">
                            <section class="page-section pt-0 px-2 px-lg-0" id="services">                    
                    <div class="container position-relative pt-30 bg-white round mt-n120 mt-sm-n60">
                        
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs tpl-alt-tabs mb-20 mb-xs-0 wow fadeInUp" data-wow-offset="0" role="tablist">
								<?php for($i=1; $i<=10; $i++){ ?>
                                   <?php 
                                      $title = "title_{$i}";
                                      $content = "content_{$i}";
                                      $image = "image_{$i}";
                                   ?>
								   <?php if($$title){ ?>
                            <li class="nav-item" role="presentation">
                                <a href="#service-<?php print $i ?>" class="nav-link <?php if($i==1){ ?>active<?php }  ?>" data-bs-toggle="tab" role="tab" aria-selected="true">
                                    
                                    <div class="alt-tabs-icon">
                                        <?php print $$image ?>
                                    </div>
                                    
                                    <?php print $$title ?>
                                    
                                </a>
                            </li>
							<?php }  ?>   
                                    <?php } ?>
                        </ul>
                        <!-- End Nav tabs -->
                        
                        <!-- Tab panes -->
                        <div class="tab-content tpl-tabs-cont">
                            
                            <?php for($i=1; $i<=10; $i++){ ?>
                                        <?php 
                                            $title = "title_{$i}";
                                            $content = "content_{$i}";
                                            $image = "icon_{$i}";
                                            $mini_description = "mini_descr_{$i}";
                                        ?>
                                        <?php if($$title){ ?>	
                            <div class="tab-pane fade show active" id="service-<?php print $i ?>" role="tabpanel">
                                
                                <div class="row">
                                    <div class="col-lg-4 mb-md-40 mb-xs-30 wow linesAnimIn" data-splitting="lines">
                                        <blockquote class="mt-0 mb-0">
                                            <p class="mb-20 mb-sm-10">
                                                <?php print $$mini_description ?>
                                            </p>
                                            <footer>
                                                Thomas Anderson
                                            </footer>
                                        </blockquote>
                                    </div>
                                    <div class="col-md-6 col-lg-4 mb-sm-30 wow linesAnimIn" data-splitting="lines">
                                        <?php print $$content ?>
                                    </div>
                                </div>                                
                                
                            </div>
							 <?php }  ?> 
                                    <?php } ?> 
                            <!-- End Service Item -->
                            
                           
                          
                            
                        </div>
                        <!-- End Tab panes -->
                    
                    </div>
                </section>
                            </div>
                        </div>
                                
                                
                            
                            
                            
        <?php return ob_get_clean(); ?>
     <?php
        }
    }
endif;
