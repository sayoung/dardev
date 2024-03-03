<?php
if (!class_exists("element_drv_element_progress")):
  class element_drv_element_progress
  {
    public function render_form()
    {
      $fields = [
        "type" => "element_element_progress",
        "title" => t("Element progress"),
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
              "style1" => "Style 1",
              "style2" => "Style 2",
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

        $fields['fields'][] = [
          'id' => "info_{$i}",
          'type' => 'info',
          'desc' => "Progress bar {$i}"
        ];

        $fields["fields"][] = [
          "id" => "title_{$i}",
          "type" => "text",
          "title" => t("Title {$i}"),
        ];

        $fields["fields"][] = [
          "id" => "valuemax_{$i}",
          "type" => "text",
          "title" => t("Progress value max {$i}"),
        ];


      }
      return $fields;
    }

    public static function render_content($attr = [], $content = "")
    {
      $default = [
        "title" => "",
        "sub_title" => "",
        "style" => "",
        "animate" => "",
        "animate_delay" => "",
        "progress_classe" => "",
        "el_class" => "",
      ];
      for ($i = 1; $i <= 5; $i++) {
        $default["title_{$i}"] = "";
        $default["valuemax_{$i}"] = "";
      }
      extract(dardev_merge_atts($default, $attr));

      $_id = "accordion-" . dardev_content_builder_makeid();
      $text_classe = "";
      $img_classe = "";

      if ($style == 'style1') {
        $progress_classe = 'tpl-progress';
        $img_classe = 'col-md-7 order-md-first';
      } elseif ($style == 'style2') {
        $progress_classe = 'tpl-progress-alt';
        $img_classe = 'col-md-7 offset-lg-1';
      }

      ob_start();
      ?>

      <section class="page-section">
        <div class="container relative">
          <div class="row">
            <div class="col-md-8 offset-md-2">
              <?php for ($i = 1; $i <= 5; $i++) { ?>
                <?php
                $title = "title_{$i}";
                $valuemax = "valuemax_{$i}";
                ?>
                <?php if ($$title && $valuemax) { ?>
                  <div class="progress <?php print $progress_classe ?>">
                    <div class="progress-bar" role="progressbar" aria-valuenow="<?php print $$valuemax ?>"
                         aria-valuemin="0"
                         aria-valuemax="100">
                      <?php if ($style == 'style1') { ?>
                        <div><?php print $$title ?>, %</div>
                        <span><?php print $$valuemax ?></span>
          <?php } elseif ($style == 'style2') { ?>
                        <?php print $$title ?>, %<?php print $$valuemax ?>
                      <?php } ?>
                    </div>
                  </div>
                <?php } ?>
              <?php } ?>
            </div>
          </div>
        </div>
      </section>

      <?php return ob_get_clean(); ?>
      <?php
    }
  }
endif;
