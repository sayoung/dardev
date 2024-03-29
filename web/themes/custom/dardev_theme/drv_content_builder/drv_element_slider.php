<?php
if (!class_exists("element_drv_element_slider")):
  class element_drv_element_slider
  {
    public function render_form()
    {
      $fields = [
        "type" => "element_element_slider",
        "title" => t("Element slider"),
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
              "left" => "Left",
              "right" => "Right",
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

      $fields['fields'][] = [
        'id' => "info_desc",
        'type' => 'info',
        'desc' => "Information slider"
      ];
      $fields["fields"][] = [
        "id" => "title_slider",
        "type" => "text",
        "title" => t("Title"),
      ];
      $fields["fields"][] = [
        "id" => "content_slider",
        "type" => "textarea_without_html",
        "title" => t("Slider description"),
      ];
      $fields["fields"][] = [
        "id" => "link_slider",
        "type" => "text",
        "desc" => "Link",
      ];
      for ($i = 1; $i <= 5; $i++) {

        $fields['fields'][] = array(
          'id' => "info_{$i}",
          'type' => 'info',
          'desc' => "Slider image {$i}"
        );


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
        "title_slider" => "",
        "content_slider" => "",
        "link_slider" => "",
        "title" => "",
        "sub_title" => "",
        "description" => "",
        "description" => "",
        "style" => "",
        "animate" => "",
        "animate_delay" => "",
        "el_class" => "",
      ];
      for ($i = 1; $i <= 5; $i++) {
        $default["title_{$i}"] = "";
        $default["image_{$i}"] = "";
        $default["link_{$i}"] = "";
        $default["content_{$i}"] = "";
      }
      extract(dardev_merge_atts($default, $attr));

      $_id = "accordion-" . dardev_content_builder_makeid();
      $text_classe = "";
      $img_classe = "";

      if ($style == 'left') {
        $text_classe = 'col-md-5 col-lg-4 offset-lg-1 mb-sm-40 d-flex align-items-center';
        $img_classe = 'col-md-7 order-md-first';
      } elseif ($style == 'right') {
        $text_classe = 'col-md-5 col-lg-4 mb-sm-40 d-flex align-items-center';
        $img_classe = 'col-md-7 offset-lg-1';
      }

      ob_start();
      ?>
      <section class="page-section">
        <div class="container relative">
          <div class="row">

            <div class="<?php print $text_classe ?>">
              <div class="w-100">
                <h2 class="section-title-small mb-30 mb-md-20"><?php print $title_slider ?></h2>
                <p class="text-gray mb-40 mb-sm-30"><?php print $content_slider ?></p>
                <div><a href="<?php print $link_slider ?>" class="btn btn-mod btn-round btn-large btn-hover-anim"><span>View</span></a>
                </div>
              </div>
            </div>

            <div class="<?php print $img_classe ?>">

              <!-- Gallery -->
              <div class="work-full-media mt-0">
                <div class="clearlist work-full-slider owl-carousel">
                  <?php for ($i = 1; $i <= 5; $i++) { ?>
                    <?php
                    $image = "image_{$i}";
                    ?>
                    <?php if ($$image) { ?>
                      <div>
                        <img class="lazyOwl" src="<?php print $$image ?>" alt="Image Description"/>
                      </div>
                    <?php } ?>
                  <?php } ?>

                </div>
              </div>
              <!-- End Gallery -->

            </div>

          </div>
        </div>
      </section>


      <?php return ob_get_clean(); ?>
      <?php
    }
  }
endif;
