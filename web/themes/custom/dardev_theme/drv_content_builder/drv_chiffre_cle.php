<?php
if (!class_exists("element_drv_chiffre_cle.php")):
    class element_drv_chiffre_cle
    {
        public function render_form()
        {
            $fields = [
                "type" => "element_drv_chiffre_cle.php",
                "title" => t("Statistiques Clés"),
                "fields" => [
                    [
                        "id" => "title",
                        "type" => "text",
                        "title" => t("Title"),
                    ],
                    [
                        "id" => "sub_title",
                        "type" => "text",
                        "title" => t("Description"),
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
            for ($i = 1; $i <= 4; $i++) {
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
                    "id" => "type_{$i}",
                    "type" => "text",
                    "title" => t("Type de value {$i}"),
                    
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
                "link_title"=> "",
                "link"=> "",
                "type"=> "",
                "style" => "",
                "animate" => "",
                "animate_delay" => "",
                "el_class" => "",
            ];
            for ($i = 1; $i <= 10; $i++) {
                $default["title_{$i}"] = "";
                $default["type_{$i}"] = "";
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
                        <!-- Achievements Section -->
						<section class="page-section bg-dark-1 bg-dark-alpha-90 parallax-5 light-content" >
							<div class="container position-relative">
								
								<div class="row">
									
									<div class="col-lg-4 mb-md-60 mb-xs-50">
										
										<h2 class="section-title mb-20 wow fadeInUp"><?php print $title; ?></h2>
										
										<p class="section-descr mb-40 wow fadeInUp" data-wow-delay="0.1s">
											<?php print $sub_title; ?>.
										</p>
										
										 <?php if($link_title){ ?>
										<div class="local-scroll wow fadeInUp" data-wow-delay="0.2s">
											<a href="<?php print $link; ?>" class="btn btn-mod btn-w btn-large btn-round btn-hover-anim"><span><?php print $link_title; ?></span></a>
										</div>
										<?php } ?> 
									</div>
									
									<div class="col-lg-7 offset-lg-1">
										
										<!-- Numbers Grid -->
										<div class="row mt-n50 mt-xs-n30">
											<?php for($i=1; $i<=10; $i++){ ?>
											<?php 
												$title = "title_{$i}";
												$type = "type_{$i}";
												$content = "content_{$i}";
											?>
											<!-- Number Item -->
											<div class="col-sm-6 col-lg-5 mt-50 mt-xs-30 wow fadeScaleIn" data-wow-delay="0.4s">
												<div class="number-title mb-10">
													<?php print $$title ?><span class="number-type"><?php print $$type ?></span>
												</div>
												<div class="number-descr">
													<?php print $$content ?>
												</div>
											</div>
											<!-- End Number Item -->
											 <?php } ?> 
											
										
										</div>
										<!-- End Numbers Grid -->
										
									</div>
									
								</div>
								
							</div>
						</section>
						<!-- End Achievements Section -->
                            
                            
        <?php return ob_get_clean(); ?>
     <?php
        }
    }
endif;
