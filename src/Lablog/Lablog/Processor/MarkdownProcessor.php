<?php

namespace Lablog\Lablog\Processor;

class MarkdownProcessor implements ProcessorInterface
{
    /**
     * Inject Markdown extra into the processor.
     * @param MichelfMarkdownExtra $markdown
     */
    public function __construct(\Michelf\MarkdownExtra $markdown)
    {
        $this->processor = $markdown;
    }

    /**
     * Process the passed in content through markdown processor.
     * @param  string $content
     * @return string
     */
    public function process($content)
    {
        return $this->processor->transform($content);
    }
}