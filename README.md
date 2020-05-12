Flug Invoice is a small library/bundle for Symfony to help you generate pdf invoices quickly, it doesn't use wkhtmltopdf 
but dompdf or you can find the [documentation here](https://github.com/dompdf/dompdf).
you can overload as you want by implementing the interface : **"Flug\Invoice\ConfigurationInterface"**.

The full configuration of dependency injection is available here:

```yaml

#flug_invoice.yaml

flug_invoice:
    currency: EUR
    decimal: 2
    logo:
        file: 'https://i.imgur.com/yRb1NQ7.png'
        height: 60
    business_details:
        name: My Company
        id: 1234567890
        phone: +34 123 456 789
        location: Main Street 1st
        zip: 08241
        city: Barcelona
        country: Spain
    footnote: ''
    tax_rates:
        - {name: '' , tax: 0 , type: percentage}
    due:
        format: M dS ,Y
        date: +3 months
    with_pagination: true
    duplication_header: false
    display_images: true
    template: '@FlugInvoice/default.html.twig'
```

The invoice template uses the [twigphp/twig](https://github.com/twigphp/Twig) rendering engine.

code example : 

```php
<?php 
use Flug\Invoice\Generator\Invoice;
use Symfony\Component\HttpFoundation\Response;

$invoice = new Invoice();
    $invoice->setName('Best Invoice');
    $invoice->setNumber((string) 1234556325);
    $invoice->setDate(new \DateTimeImmutable());
    $invoice->setCustomerDetails('Best Customer', (string) 1234556, '+33 630301023', '44000', 'Nantes', 'France',
        '36 quai des orfèvres');
    $invoice->addItem('Test Item', 10.25, 2, 1412)
        ->addItem('Test Item 3', 15.55, 5, 42)
        ->addItem('Test Item 4', 1.25, 1, 923)
        ->addItem('Test Item 5', 3.12, 1, 3142)
        ->addItem('Test Item 6', 6.41, 3, 452)
        ->addItem('Test Item 7', 2.86, 1, 1526)
        ->addItem('Test Item 8', 5, 2, 923, 'https://dummyimage.com/64x64/000/fff')
        ->setNotes('toto notes <br>');
    $renderer = $this->pdf->generate($invoice);
    $stream = $renderer->output();

return new Response($stream, 200, ['Content-type' => 'application/pdf']);
```

More tests are coming soon...

