<?php
if (!class_exists("element_drv_element_slider_multiple")):
  class element_drv_element_slider_multiple
  {
    public function render_form()
    {
      $fields = [
        "type" => "element_element_slider",
        "title" => t("Element slider multiple"),
        "fields" => [
          [
            "id" => "title",
            "type" => "text",
            "title" => t("Title"),
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

      for ($i = 1; $i <= 5; $i++) {

        $fields['fields'][] = array(
          'id' => "info_{$i}",
          'type' => 'info',
          'desc' => "Slider image {$i}"
        );

        $fields["fields"][] = [
          "id" => "title_{$i}",
          "type" => "text",
          "title" => t("Title"),
        ];

        $fields["fields"][] = [
          "id" => "content_{$i}",
          "type" => "textarea_without_html",
          "title" => t("Slider description"),
        ];

        $fields["fields"][] = [
          "id" => "link_{$i}",
          "type" => "text",
          "desc" => "Link",
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
      <div class="fullwidth-slider owl-carousel bg-gray">
        <?php for ($i = 1; $i <= 5; $i++) { ?>
          <?php $title = "title_{$i}";
          $content = "content_{$i}";
          $image = "image_{$i}";
          $link = "link_{$i}"; ?>
          <?php if ($$title && $$image) { ?>
            <section class="page-section bg-gray-lighter">
              <div class="container relative">
                <div class="row">

                  <div class="col-md-7 mb-sm-40">
                    <div class="work-full-media mt-0"><img src="<?php print $$image ?>"/></div>
                  </div>

                  <div class="col-md-5 col-lg-4 offset-lg-1 d-flex align-items-center">

                    <div class="w-100">

                      <h2 class="section-title-small mb-30 mb-md-20"><?php print $$title ?></h2>

                      <p class="text-gray mb-40 mb-sm-30"><?php print $$content ?></p>

                      <div>
                        <a href="<?php print $$link ?>" class="btn btn-mod btn-round btn-large btn-hover-anim"><span>View Project 1</span></a>
                      </div>

                    </div>

                  </div>
                </div>
              </div>
            </section>
          <?php } ?>
        <?php } ?>
      </div>


      <?php return ob_get_clean(); ?>
      <?php
    }
  }
endif;
