<?php

/*
 * This file is part of FlugInvoice project.
 *
 * (c) Flug <flug@clooder.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Flug\Invoice\Generator;

use Dompdf\Dompdf;
use Dompdf\Options;
use Flug\Invoice\ConfigurationInterface;
use Twig\Environment;

class Pdf
{
    private ConfigurationInterface $setting;

    private Environment $templateEngine;
    private $streamContext;

    public function __construct(ConfigurationInterface $setting, Environment $templateEngine)
    {
        $this->setting = $setting;
        $this->templateEngine = $templateEngine;
        $this->streamContext = stream_context_create([
            'ssl' => [
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true,
            ],
        ]);
    }

    public function generate(InvoiceInterface $invoice)
    {
        $options = new Options();
        $options->set('isRemoteEnabled', true);
        $options->set('isPhpEnabled', false);
        $pdf = new Dompdf($options);
        $view = $this->templateEngine->render($this->setting->getTemplate(),
            [
                'setting' => $this->setting,
            ] + $invoice->getInvoice()
        );
        $pdf->loadHtml($view);
        $pdf->render();
        $pdf->setHttpContext($this->streamContext);

        return $pdf;
    }
}
