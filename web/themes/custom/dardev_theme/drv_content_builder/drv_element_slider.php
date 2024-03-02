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

      $fields['fields'][] = [
        'id' => "info_0",
        'type' => 'info',
        'desc' => "Information slider"
      ];
      $fields["fields"][] = [
        "id" => "title_0",
        "type" => "text",
        "title" => t("Title"),
      ];
      $fields["fields"][] = [
        "id" => "content_0",
        "type" => "textarea_without_html",
        "title" => t("Slider description"),
      ];
      $fields["fields"][] = [
        "id" => "link_0",
        "type" => "text",
        "desc" => "Link",
      ];
      for ($i = 1; $i <= 10; $i++) {

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
        $default["link_{$i}"] = "";
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
      <section class="page-section">
        <div class="container relative">
          <div class="row">

            <div class="col-md-5 col-lg-4 offset-lg-1 mb-sm-40 d-flex align-items-center">
              <div class="w-100">
                <?php
                $title = "title_0";
                $desc = "content_0";
                $link = "link_0";
                ?>
                <h2 class="section-title-small mb-30 mb-md-20"><?php print $$title ?></h2>
                <p class="text-gray mb-40 mb-sm-30"><?php print $$desc ?></p>
                <div><a href="<?php print $$link ?>" class="btn btn-mod btn-round btn-large btn-hover-anim"><span>View</span></a></div>
              </div>
            </div>

            <div class="col-md-7 order-md-first">

              <!-- Gallery -->
              <div class="work-full-media mt-0">
                <div class="clearlist work-full-slider owl-carousel">
                  <?php for ($i = 1; $i <= 10; $i++) { ?>
                    <?php
                    $image = "image_{$i}";
                    ?>
                  <div>
                    <img class="lazyOwl" src="<?php print $$image ?>" alt="Image Description" />
                  </div>
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
