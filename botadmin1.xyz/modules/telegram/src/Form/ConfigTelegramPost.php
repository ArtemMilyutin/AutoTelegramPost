<?php
/**
 * @file
 * Contains \Drupal\telegram\Form\ConfigModule.
 *
 * В комментарии выше указываем, что содержится в данном файле.
 */
// Объявляем пространство имён формы. Drupal\НАЗВАНИЕ_МОДУЛЯ\Form
namespace Drupal\telegram\Form;

// Указываем что нам потребуется ConfigFormBase, от которого мы будем наследоваться
// а также FormStateInterface который позволит работать с данными.
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Объявляем нашу форму, наследуясь от ConfigFormBase.
 * Название класса строго должно соответствовать названию файла.
 */
class ConfigTelegramPost extends FormBase 
{

  /**
   * То что ниже - это аннотация. Аннотации пишутся в комментариях и в них
   * объявляются различные данные. В данном случае указано, что документацию
   * к данному методу надо взять из комментария к самому классу.
   *
   * А в самом методе мы возвращаем название нашей формы в виде строки.
   * Эта строка используется для альтера формы (об этом ниже в тексте).
   *
   * {@inheritdoc}.
   */

   public function getFormId() {
    return 'config_post';
  }
  /**
   * Создание нашей формы.
   *
   * {@inheritdoc}.
   */
  public function buildForm(array $form, FormStateInterface $form_state) 
  {
    // Объявляем телефон.
	$config = \Drupal::config('telegram.config_post.settings');
    $form['chat_id'] = array(
      '#type' => 'textfield',
      // Не забываем из Drupal 7, что t, в D8 $this->t() можно использовать
      // только с английскими словами. Иначе не используйте t() а пишите
      // просто строку.
      '#title' => $this->t('Your chat id'),
      '#default_value' => $config->get('chat_id')

    );

    $form['token'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Your token'),
      '#default_value' => $config->get('token')
	  
    );

    // Предоставляет обёртку для одного или более Action элементов.
    $form['actions']['#type'] = 'actions';
    // Добавляем нашу кнопку для отправки.
    $form['actions']['submit'] = array(
      '#type' => 'submit',
      '#value' => $this->t('Send token and id'),
      '#button_type' => 'primary',
    );
	
	
    return $form;
  }

  /**
   * Валидация отправленых данных в форме.
   *
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    // Если длина имени меньше 10, выводим ошибку.
    if (strlen($form_state->getValue('token')) < 10) {
      $form_state->setErrorByName('token', $this->t('Token is too short.'));
    }
  }

  /**
   * Отправка формы.
   *
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // Мы ничего не хотим делать с данными, просто выведем их в системном
    // сообщении.
	//$char_id= $form_state->getValue('chat_id');
    drupal_set_message($this->t('your @token, your id is @chat_id', array(
      '@token' => $form_state->getValue('token'),
      '@chat_id' => $form_state->getValue('chat_id')
    )));
  }
}