<?php

/**
 * Генерация sitemap.xml
 * @author Yevgeny Skuridin
 */
class SitemapGenerator extends CApplicationComponent {

    private $_sitemapUrl; //url файлы с картой сайта
    private $_path; //путь для сохранения сайтмепа (/srv/mysite/www/)
    private $_xml; //объект класса DOMDocument
    private $_urlSet; //родительский элемент сайтмапа

    // Адреса для скармливания карты
    private $_pingGoogle;
    private $_pingYandex;
    private $_pingYahoo;
    private $_pingBing;
    private $_pingAsk;

    /**
     * Капитан Очевидность
     * @return \SitemapGenerator
     */
    public function init() {
        //создаем xml
        $this->_xml     = new DOMDocument('1.0', 'UTF-8');
        $this->_urlSet  = $this->_xml->appendChild($this->_xml->createElement('urlset'));
        //добавляем необходимые атрибуты по стандарту сайтмапа
        $this->_urlSet->setAttribute('xmlns', 'http://www.sitemaps.org/schemas/sitemap/0.9');
    }

    public function setPath($path) {
        $this->_path = $path;
    }
    public function setSitemapUrl($sitemapUrl) {
        $this->_sitemapUrl = $sitemapUrl;
    }
    public function setPingGoogle($url) {
        $this->_pingGoogle = $url;
    }
    public function setPingYandex($url) {
        $this->_pingYandex = $url;
    }
    public function setPingYahoo($url) {
        $this->_pingYahoo = $url;
    }
    public function setPingBing($url) {
        $this->_pingBing = $url;
    }
    public function setPingAsk($url) {
        $this->_pingAsk = $url;
    }

    /**
     * Добавление элемента в карту сайта
     * @param string $locData Адрес страницы
     * @param string $lastmodData Дата последней модификации в unixtime
     * @param string $changefreqData Интенсивность изменения
     * @param string $priorityData Приоритет
     * @return \SitemapGenerator
     */
    public function addNode($locData, $lastmodData, $changefreqData = 'monthly', $priorityData = '0.5') {
        //создаем ноду
        $url            = $this->_urlSet->appendChild($this->_xml->createElement('url'));
        //создаем параметры в ноде
        $loc            = $url->appendChild($this->_xml->createElement('loc'));
        $lastmod        = $url->appendChild($this->_xml->createElement('lastmod'));
        $changefreq     = $url->appendChild($this->_xml->createElement('changefreq'));
        $priority       = $url->appendChild($this->_xml->createElement('priority'));
        //заполняем ноду данными
        $loc->appendChild($this->_xml->createTextNode($locData));
        $lastmod->appendChild($this->_xml->createTextNode(date(DATE_ISO8601, $lastmodData)));
        $changefreq->appendChild($this->_xml->createTextNode($changefreqData));
        $priority->appendChild($this->_xml->createTextNode($priorityData));
    }

    /**
     * Сохранение сайтмапа в файл
     * @return \SitemapGenerator
     */
    public function save() {
        $this->_xml->formatOutput = TRUE;
        $this->_xml->save($this->_path);
    }

    /**
     * Оповещает поисковик о обновлении карты сайта
     * @param type $url
     * @return \SitemapGenerator
     */
    public function ping($url) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url.'/'.$this->_sitemapUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_exec($ch);
    }
    public function pingGoogle() {
        $this->ping($this->_pingGoogle);
    }
    public function pingYandex() {
        $this->ping($this->_pingYandex);
    }
    public function pingBing() {
        $this->ping($this->_pingBing);
    }
    public function pingYahoo() {
        $this->ping($this->_pingYahoo);
    }
    public function pingAsk() {
        $this->ping($this->_pingAsk);
    }
}