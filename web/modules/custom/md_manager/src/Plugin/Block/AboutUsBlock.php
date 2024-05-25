<?php declare(strict_types=1);

namespace Drupal\md_manager\Plugin\Block;

use Drupal\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Config\Config;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Language\LanguageManagerInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\file\Entity\File;
use Drupal\image\Entity\ImageStyle;
use Drupal\node\Entity\Node;
use Drupal\node\NodeInterface;

/**
 * Provides a steps process block.
 *
 * @Block(
 *   id = "md_manager_about_us",
 *   admin_label = @Translation("About us"),
 *   category = @Translation("Custom"),
 * )
 */
final class AboutUsBlock extends BlockBase implements ContainerFactoryPluginInterface
{


  const TYPE_ABOUT = 'about';

  protected $entityTypeManager;

  protected $languageManager;

  /**
   * The configuration object.
   *
   * @var Config
   */
  protected $config;

  /**
   * Constructs a new CustomFormBlock.
   *
   * @param array $configuration
   *   A configuration array containing information about the plugin instance.
   * @param string $plugin_id
   *   The plugin_id for the plugin instance.
   * @param mixed $plugin_definition
   *   The plugin implementation definition.
   * @param Config $config
   *   The configuration object.
   */
  public function __construct(
                              array $configuration,
                              $plugin_id,
                              $plugin_definition,
                              Config $config,
                              EntityTypeManagerInterface $entityTypeManager,
                              LanguageManagerInterface $languageManager
  )
  {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->config = $config;
    $this->entityTypeManager = $entityTypeManager;
    $this->languageManager = $languageManager;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface|\Symfony\Component\DependencyInjection\ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition)
  {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('config.factory')->get('md_manager.settings'),
      $container->get('entity_type.manager'),
      $container->get('language_manager')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function build(): array
  {
    $data = $this->getBlockType(self::TYPE_ABOUT);

    return [
      '#theme' => 'about_us',
      '#content' => $data
    ];
  }

  /**
   * @param string $type
   * @return array
   */
  private function getBlockType(string $type): array
  {
    $language = $this->languageManager->getCurrentLanguage();
    $currentLang = $language->getId();
    $query = $this->entityTypeManager->getStorage('block_content')->getQuery()
      ->condition('type', $type)
      ->condition('langcode', $currentLang)
      ->accessCheck(FALSE)
      ->range(0, 1);
    $block_ids = $query->execute();

    $content = $phone = $title = $email = NULL;
    if (!empty($block_ids)) {
      $block_id = reset($block_ids);
      $block = $this->entityTypeManager->getStorage('block_content')->load($block_id);
      if ($block->hasTranslation($currentLang)) {
        $translatedBlock = $block->getTranslation($currentLang);
        $title = $translatedBlock->get('info')->value;
        $content = $translatedBlock->get('body')->value;
        $phone = $type == 'about' ? $translatedBlock->get('field_email')->value : '';
        $email = $type == 'about' ? $translatedBlock->get('field_phone')->value : '';
      } else {
        $title = $block->get('info')->value;
        $content = $block->get('body')->value;
        $phone = $type == 'about' ? $block->get('field_email')->value : '';
        $email = $type == 'about' ? $block->get('field_phone')->value : '';

      }
    }
    /* Test */
    return [
      'title' => $title,
      'content' => $content,
      'phone' => $phone,
      'email' => $email
    ];

  }

}
