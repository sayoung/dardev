<?php
if (!class_exists("element_drv_element_tabs")):
  class element_drv_element_tabs
  {
    public function render_form()
    {
      $fields = [
        "type" => "element_element_tabs",
        "title" => t("Element Tabs"),
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
        ],
      ];

      for ($i = 1; $i <= 5; $i++) {

        $fields['fields'][] = [
          'id' => "info_{$i}",
          'type' => 'info',
          'desc' => "Tab {$i}"
        ];

        $fields["fields"][] = [
          "id" => "title_{$i}",
          "type" => "text",
          "title" => t("Title {$i}"),
        ];

        $fields["fields"][] = [
          "id" => "desc_{$i}",
          "type" => "text",
          "title" => t("Tab description {$i}"),
        ];


      }
      return $fields;
    }

    public static function render_content($attr = [], $content = "")
    {
      $default = [
        "title" => "",
        "desc" => "",
        "style" => "",
        "animate" => "",
        "animate_delay" => "",
        "tabs_classe" => "",
        "tab_content_classe" => "",
      ];
      for ($i = 1; $i <= 5; $i++) {
        $default["title_{$i}"] = "";
        $default["desc_{$i}"] = "";
      }
      extract(dardev_merge_atts($default, $attr));

      $_id = "accordion-" . dardev_content_builder_makeid();
      $tabs_classe = '';
      $tab_content_classe = '';

      if ($style == 'style1') {
        $tabs_classe = 'tpl-tabs';
      } elseif ($style == 'style2') {
        $tabs_classe = 'tpl-minimal-tabs';
        $tab_content_classe = 'text-center';
      }

      ob_start();
      ?>

      <section class="page-section">
        <div class="container relative">
          <div class="row">

            <div class="col-sm-8 offset-sm-2">


              <div class="text-center mb-40 mb-xxs-30">
                <ul class="nav nav-tabs <?php print $tabs_classe ?> animate" role="tablist">
                  <?php for ($i = 1; $i <= 5; $i++) { ?>
                    <?php
                    $title = "title_{$i}";
                    $desc = "desc_{$i}";
                    ?>
                    <?php if ($$title && $$desc) { ?>
                      <li class="nav-item" role="presentation">
                        <a href="#item-<?php print $i ?>" aria-controls="item-<?php print $i ?>" class="nav-link <?php if ($i ==1) { ?>active<?php } ?>" data-bs-toggle="tab"  role="tab" aria-selected="true"><?php print $$title ?></a>
                      </li>
                    <?php } ?>
                  <?php } ?>
                </ul>
              </div>

              <div class="tab-content tpl-minimal-tabs-cont <?php print $tab_content_classe ?>">
                <?php for ($i = 1; $i <= 5; $i++) { ?>
                  <?php
                  $title = "title_{$i}";
                  $desc = "desc_{$i}";
                  ?>
                  <?php if ($$title && $$desc) { ?>
                    <div class="tab-pane fade <?php if ($i ==1) { ?>show active<?php } ?>" id="item-<?php print $i ?>" role="tabpanel"><?php print $$desc ?></div>
                  <?php } ?>
                <?php } ?>
              </div>


            </div>

          </div>
        </div>
      </section>

      <?php return ob_get_clean(); ?>
      <?php
    }
  }
endif;
