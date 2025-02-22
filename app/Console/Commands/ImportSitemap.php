<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Question;
use Illuminate\Support\Facades\Storage;
use SimpleXMLElement;
use Illuminate\Support\Str;

class ImportSitemap extends Command
{
  protected $signature = 'import:sitemap';
  protected $description = 'Import URLs from sitemap.xml into the questions table';

  public function handle()
  {
    $filePath = base_path('database/sitemap.xml');
    // Store it in storage/app/database
    if (!file_exists($filePath)) {
      $this->error("File not found: $filePath");
      return;
    }

    $sitemap = simplexml_load_file($filePath);
    if (!$sitemap) {
      $this->error("Invalid XML format");
      return;
    }

    $disallowedSegments = [
      'content_',
      'questions_',
      'whats-new.html',
      'questweek.html',
      'questweek-archive.html',
      'top20',
      'archive.html',
      'gqaudio',
      'sitemap.html',
      'faith.html',
      'about.html',
      'GotQuestions-expertise.html',
      'privacy.html',
      'copyright.html',
      'citation.html',
      'Bible-Questions.html',
      'international.html',
      'support.html',
      'donate.html',
      'donate-monthly.html',
      'alexa.html',
      'Got-Questions-Video.htm',
      '-Survey',
      'content.html',
      'book'
    ];

    $urls = [];
    foreach ($sitemap->url as $urlElement) {
      $url = (string) $urlElement->loc;

      if (Str::contains($url, $disallowedSegments)) {
        continue;
      }

      if ($url == 'https://www.gotquestions.org') {
        continue;
      }

      $urls[] = ['url' => $url, 'created_at' => now(), 'updated_at' => now()];
    }

    Question::upsert($urls, ['url'], ['updated_at']); // Avoid duplicate entries

    $this->info("Imported " . count($urls) . " URLs successfully!");
    $this->info("Imported " . $urls[15]['url'] . " URLs successfully!");
  }
}
