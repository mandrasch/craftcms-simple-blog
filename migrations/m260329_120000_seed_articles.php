<?php

use craft\db\Migration;
use craft\elements\Entry;

class m260329_120000_seed_articles extends Migration
{
    public function safeUp(): bool
    {
        $section = \Craft::$app->entries->getSectionByHandle('articles');
        if (!$section) {
            echo "Section 'articles' not found.\n";
            return false;
        }

        $entryType = \Craft::$app->entries->getEntryTypeByHandle('article');
        if (!$entryType) {
            echo "Entry type 'article' not found.\n";
            return false;
        }

        $articles = [
            [
                'title' => 'Albert Camus: Embracing the Absurd',
                'teaserText' => '<p>For Camus, the purpose of life is not found in grand meaning — but in our defiant response to its absence.</p>',
                'text' => '<p>Albert Camus argued that life has no inherent meaning. The universe is indifferent, and our search for purpose meets only silence. He called this confrontation between human longing and the world\'s silence <em>the absurd</em>.</p><p>But rather than despair, Camus proposed revolt. In <em>The Myth of Sisyphus</em>, he asks us to imagine Sisyphus happy — endlessly rolling his boulder, fully aware of its futility, yet choosing to embrace the struggle itself.</p><p>The purpose of life, for Camus, is to live fully and passionately in spite of meaninglessness. To create, to love, to experience — not because it leads somewhere, but because the act of living is enough.</p>',
            ],
            [
                'title' => 'Simone de Beauvoir: Freedom Through Commitment',
                'teaserText' => '<p>De Beauvoir saw the purpose of life in the exercise of freedom — not in isolation, but through genuine engagement with others.</p>',
                'text' => '<p>Simone de Beauvoir, in <em>The Ethics of Ambiguity</em>, argued that human existence is fundamentally ambiguous — we are both free and constrained, both subject and object. Purpose is not given to us; we must create it through action.</p><p>But freedom alone is not enough. De Beauvoir insisted that our freedom is meaningful only when it aims to liberate others as well. A life turned inward, avoiding commitment, is a life in bad faith.</p><p>The purpose of life, for de Beauvoir, is to embrace our freedom honestly, commit to projects and relationships that matter, and work toward a world where others can be free too.</p>',
            ],
            [
                'title' => 'Irvin Yalom: Meaning in the Face of Death',
                'teaserText' => '<p>Yalom, as both philosopher and therapist, found that confronting mortality is what gives life its urgency and depth.</p>',
                'text' => '<p>Irvin Yalom identified four ultimate concerns of human existence: death, freedom, isolation, and meaninglessness. Rather than avoiding these realities, he argued that facing them directly is the path to a fuller life.</p><p>Death, in particular, serves as an awakening. Yalom observed in his therapeutic practice that patients who truly confronted their mortality often underwent profound shifts — they stopped postponing life and began living with greater intention.</p><p>For Yalom, the purpose of life is not a cosmic answer but a personal project. We create meaning through love, through creative work, and through the courage to engage authentically with others despite knowing that everything is temporary.</p>',
            ],
        ];

        foreach ($articles as $data) {
            $entry = new Entry();
            $entry->sectionId = $section->id;
            $entry->typeId = $entryType->id;
            $entry->title = $data['title'];
            $entry->setFieldValues([
                'teaserText' => $data['teaserText'],
                'text' => $data['text'],
            ]);

            if (!\Craft::$app->elements->saveElement($entry)) {
                echo "Failed to save '{$data['title']}': " . implode(', ', $entry->getErrorSummary(true)) . "\n";
                return false;
            }
        }

        return true;
    }

    public function safeDown(): bool
    {
        $entries = Entry::find()->section('articles')->all();
        foreach ($entries as $entry) {
            \Craft::$app->elements->deleteElement($entry);
        }
        return true;
    }
}
