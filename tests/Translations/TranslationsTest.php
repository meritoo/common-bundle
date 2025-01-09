<?php

/**
 * (c) Meritoo.pl, http://www.meritoo.pl
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Meritoo\Test\CommonBundle\Translations;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Test of translations data
 *
 * @author Krzysztof Nizioł <krzysztof.niziol@meritoo.pl>
 * @copyright Meritoo.pl <http://www.meritoo.pl>
 *
 * @coversNothing
 */
class TranslationsTest extends KernelTestCase
{
    private TranslatorInterface $translator;

    public function providePlurals(): \Generator
    {
        // Action
        yield '0 Actions' => ['meritoo_common.general.action', ['count' => 0], 'words', 'pl', 'Akcji'];
        yield '1 Action' => ['meritoo_common.general.action', ['count' => 1], 'words', 'pl', 'Akcja'];
        yield '2 Actions' => ['meritoo_common.general.action', ['count' => 2], 'words', 'pl', 'Akcje'];
        yield '5 Actions' => ['meritoo_common.general.action', ['count' => 5], 'words', 'pl', 'Akcji'];
        yield '100 Actions' => ['meritoo_common.general.action', ['count' => 100], 'words', 'pl', 'Akcji'];

        yield '0 Actions DE' => ['meritoo_common.general.action', ['count' => 0], 'words', 'de', 'Aktionen'];
        yield '1 Action DE' => ['meritoo_common.general.action', ['count' => 1], 'words', 'de', 'Aktion'];
        yield '2 Actions DE' => ['meritoo_common.general.action', ['count' => 2], 'words', 'de', 'Aktionen'];
        yield '5 Actions DE' => ['meritoo_common.general.action', ['count' => 5], 'words', 'de', 'Aktionen'];
        yield '100 Actions DE' => ['meritoo_common.general.action', ['count' => 100], 'words', 'de', 'Aktionen'];

        // Error
        yield '0 Errors' => ['meritoo_common.general.error', ['count' => 0], 'words', 'pl', 'Błędów'];
        yield '1 Error' => ['meritoo_common.general.error', ['count' => 1], 'words', 'pl', 'Błąd'];
        yield '2 Errors' => ['meritoo_common.general.error', ['count' => 2], 'words', 'pl', 'Błędy'];
        yield '5 Errors' => ['meritoo_common.general.error', ['count' => 5], 'words', 'pl', 'Błędów'];
        yield '100 Errors' => ['meritoo_common.general.error', ['count' => 100], 'words', 'pl', 'Błędów'];

        // Advantage
        yield '0 Advantages DE' => ['meritoo_common.general.advantage', ['count' => 0], 'words', 'pl', 'Zalet'];
        yield '1 Advantage DE' => ['meritoo_common.general.advantage', ['count' => 1], 'words', 'pl', 'Zaleta'];
        yield '2 Advantages DE' => ['meritoo_common.general.advantage', ['count' => 2], 'words', 'pl', 'Zalety'];
        yield '5 Advantages DE' => ['meritoo_common.general.advantage', ['count' => 5], 'words', 'pl', 'Zalet'];
        yield '100 Advantages DE' => ['meritoo_common.general.advantage', ['count' => 100], 'words', 'pl', 'Zalet'];

        yield '0 Advantages' => ['meritoo_common.general.advantage', ['count' => 0], 'words', 'de', 'Vorteile'];
        yield '1 Advantage' => ['meritoo_common.general.advantage', ['count' => 1], 'words', 'de', 'Vorteil'];
        yield '2 Advantages' => ['meritoo_common.general.advantage', ['count' => 2], 'words', 'de', 'Vorteile'];
        yield '5 Advantages' => ['meritoo_common.general.advantage', ['count' => 5], 'words', 'de', 'Vorteile'];
        yield '100 Advantages' => ['meritoo_common.general.advantage', ['count' => 100], 'words', 'de', 'Vorteile'];

        // Invitation
        yield '0 Invitations' => ['meritoo_common.general.invitation', ['count' => 0], 'words', 'pl', 'Zaproszeń'];
        yield '1 Invitation' => ['meritoo_common.general.invitation', ['count' => 1], 'words', 'pl', 'Zaproszenie'];
        yield '2 Invitations' => ['meritoo_common.general.invitation', ['count' => 2], 'words', 'pl', 'Zaproszenia'];
        yield '5 Invitations' => ['meritoo_common.general.invitation', ['count' => 5], 'words', 'pl', 'Zaproszeń'];
        yield '100 Invitations' => ['meritoo_common.general.invitation', ['count' => 100], 'words', 'pl', 'Zaproszeń'];

        // Ingredient
        yield '0 Ingredients' => ['meritoo_common.general.ingredient', ['count' => 0], 'words', 'pl', 'Składników'];
        yield '1 Ingredient' => ['meritoo_common.general.ingredient', ['count' => 1], 'words', 'pl', 'Składnik'];
        yield '2 Ingredients' => ['meritoo_common.general.ingredient', ['count' => 2], 'words', 'pl', 'Składniki'];
        yield '5 Ingredients' => ['meritoo_common.general.ingredient', ['count' => 5], 'words', 'pl', 'Składników'];
        yield '100 Ingredients' => ['meritoo_common.general.ingredient', ['count' => 100], 'words', 'pl', 'Składników'];

        // Picture
        yield '0 Pictures' => ['meritoo_common.general.picture', ['count' => 0], 'words', 'pl', 'Obrazków'];
        yield '1 Picture' => ['meritoo_common.general.picture', ['count' => 1], 'words', 'pl', 'Obrazek'];
        yield '2 Pictures' => ['meritoo_common.general.picture', ['count' => 2], 'words', 'pl', 'Obrazki'];
        yield '5 Pictures' => ['meritoo_common.general.picture', ['count' => 5], 'words', 'pl', 'Obrazków'];
        yield '100 Pictures' => ['meritoo_common.general.picture', ['count' => 100], 'words', 'pl', 'Obrazków'];

        // Photo
        yield '0 Photos' => ['meritoo_common.general.photo', ['count' => 0], 'words', 'pl', 'Zdjęć'];
        yield '1 Photo' => ['meritoo_common.general.photo', ['count' => 1], 'words', 'pl', 'Zdjęcie'];
        yield '2 Photos' => ['meritoo_common.general.photo', ['count' => 2], 'words', 'pl', 'Zdjęcia'];
        yield '5 Photos' => ['meritoo_common.general.photo', ['count' => 5], 'words', 'pl', 'Zdjęć'];
        yield '100 Photos' => ['meritoo_common.general.photo', ['count' => 100], 'words', 'pl', 'Zdjęć'];

        // Certificate
        yield '0 Certificates' => ['meritoo_common.general.certificate', ['count' => 0], 'words', 'pl', 'Certyfikatów'];
        yield '1 Certificate' => ['meritoo_common.general.certificate', ['count' => 1], 'words', 'pl', 'Certyfikat'];
        yield '2 Certificates' => ['meritoo_common.general.certificate', ['count' => 2], 'words', 'pl', 'Certyfikaty'];
        yield '5 Certificates' => ['meritoo_common.general.certificate', ['count' => 5], 'words', 'pl', 'Certyfikatów'];
        yield '100 Certificates' => ['meritoo_common.general.certificate', ['count' => 100], 'words', 'pl', 'Certyfikatów'];

        // Message
        yield '0 Messages' => ['meritoo_common.general.message', ['count' => 0], 'words', 'pl', 'Wiadomości'];
        yield '1 Message' => ['meritoo_common.general.message', ['count' => 1], 'words', 'pl', 'Wiadomość'];
        yield '2 Messages' => ['meritoo_common.general.message', ['count' => 2], 'words', 'pl', 'Wiadomości'];
        yield '5 Messages' => ['meritoo_common.general.message', ['count' => 5], 'words', 'pl', 'Wiadomości'];
        yield '100 Messages' => ['meritoo_common.general.message', ['count' => 100], 'words', 'pl', 'Wiadomości'];

        // Day
        yield '0 Days' => ['meritoo_common.general.day', ['count' => 0], 'words', 'pl', 'Dni'];
        yield '1 Day' => ['meritoo_common.general.day', ['count' => 1], 'words', 'pl', 'Dzień'];
        yield '2 Days' => ['meritoo_common.general.day', ['count' => 2], 'words', 'pl', 'Dni'];
        yield '5 Days' => ['meritoo_common.general.day', ['count' => 5], 'words', 'pl', 'Dni'];
        yield '100 Days' => ['meritoo_common.general.day', ['count' => 100], 'words', 'pl', 'Dni'];

        // Month
        yield '0 Months' => ['meritoo_common.general.month', ['count' => 0], 'words', 'pl', 'Miesięcy'];
        yield '1 Month' => ['meritoo_common.general.month', ['count' => 1], 'words', 'pl', 'Miesiąc'];
        yield '2 Months' => ['meritoo_common.general.month', ['count' => 2], 'words', 'pl', 'Miesiące'];
        yield '5 Months' => ['meritoo_common.general.month', ['count' => 5], 'words', 'pl', 'Miesięcy'];
        yield '100 Months' => ['meritoo_common.general.month', ['count' => 100], 'words', 'pl', 'Miesięcy'];

        // Year
        yield '0 Years' => ['meritoo_common.general.year', ['count' => 0], 'words', 'pl', 'Lat'];
        yield '1 Year' => ['meritoo_common.general.year', ['count' => 1], 'words', 'pl', 'Rok'];
        yield '2 Years' => ['meritoo_common.general.year', ['count' => 2], 'words', 'pl', 'Lata'];
        yield '5 Years' => ['meritoo_common.general.year', ['count' => 5], 'words', 'pl', 'Lat'];
        yield '100 Years' => ['meritoo_common.general.year', ['count' => 100], 'words', 'pl', 'Lat'];

        // Transaction
        yield '0 Transactions' => ['meritoo_common.finances.transaction', ['count' => 0], 'words', 'pl', 'Transakcji'];
        yield '1 Transaction' => ['meritoo_common.finances.transaction', ['count' => 1], 'words', 'pl', 'Transakcja'];
        yield '2 Transactions' => ['meritoo_common.finances.transaction', ['count' => 2], 'words', 'pl', 'Transakcje'];
        yield '5 Transactions' => ['meritoo_common.finances.transaction', ['count' => 5], 'words', 'pl', 'Transakcji'];
        yield '100 Transactions' => ['meritoo_common.finances.transaction', ['count' => 100], 'words', 'pl', 'Transakcji'];

        // Page
        yield '0 Pages' => ['meritoo_common.pagination.page', ['count' => 0], 'words', 'pl', 'Stron'];
        yield '1 Page' => ['meritoo_common.pagination.page', ['count' => 1], 'words', 'pl', 'Strona'];
        yield '2 Pages' => ['meritoo_common.pagination.page', ['count' => 2], 'words', 'pl', 'Strony'];
        yield '5 Pages' => ['meritoo_common.pagination.page', ['count' => 5], 'words', 'pl', 'Stron'];
        yield '100 Pages' => ['meritoo_common.pagination.page', ['count' => 100], 'words', 'pl', 'Stron'];
    }

    public function providePluralsForDefaultLocale(): \Generator
    {
        // Action
        yield '0 Actions' => ['meritoo_common.general.action', ['count' => 0], 'words', 'Actions'];
        yield '1 Action' => ['meritoo_common.general.action', ['count' => 1], 'words', 'Action'];
        yield '2 Actions' => ['meritoo_common.general.action', ['count' => 2], 'words', 'Actions'];
        yield '5 Actions' => ['meritoo_common.general.action', ['count' => 5], 'words', 'Actions'];
        yield '100 Actions' => ['meritoo_common.general.action', ['count' => 100], 'words', 'Actions'];

        // Error
        yield '0 Errors' => ['meritoo_common.general.error', ['count' => 0], 'words', 'Errors'];
        yield '1 Error' => ['meritoo_common.general.error', ['count' => 1], 'words', 'Error'];
        yield '2 Errors' => ['meritoo_common.general.error', ['count' => 2], 'words', 'Errors'];
        yield '5 Errors' => ['meritoo_common.general.error', ['count' => 5], 'words', 'Errors'];
        yield '100 Errors' => ['meritoo_common.general.error', ['count' => 100], 'words', 'Errors'];

        // Advantage
        yield '0 Advantages' => ['meritoo_common.general.advantage', ['count' => 0], 'words', 'Advantages'];
        yield '1 Advantage' => ['meritoo_common.general.advantage', ['count' => 1], 'words', 'Advantage'];
        yield '2 Advantages' => ['meritoo_common.general.advantage', ['count' => 2], 'words', 'Advantages'];
        yield '5 Advantages' => ['meritoo_common.general.advantage', ['count' => 5], 'words', 'Advantages'];
        yield '100 Advantages' => ['meritoo_common.general.advantage', ['count' => 100], 'words', 'Advantages'];

        // Invitation
        yield '0 Invitations' => ['meritoo_common.general.invitation', ['count' => 0], 'words', 'Invitations'];
        yield '1 Invitation' => ['meritoo_common.general.invitation', ['count' => 1], 'words', 'Invitation'];
        yield '2 Invitations' => ['meritoo_common.general.invitation', ['count' => 2], 'words', 'Invitations'];
        yield '5 Invitations' => ['meritoo_common.general.invitation', ['count' => 5], 'words', 'Invitations'];
        yield '100 Invitations' => ['meritoo_common.general.invitation', ['count' => 100], 'words', 'Invitations'];

        // Ingredient
        yield '0 Ingredients' => ['meritoo_common.general.ingredient', ['count' => 0], 'words', 'Ingredients'];
        yield '1 Ingredient' => ['meritoo_common.general.ingredient', ['count' => 1], 'words', 'Ingredient'];
        yield '2 Ingredients' => ['meritoo_common.general.ingredient', ['count' => 2], 'words', 'Ingredients'];
        yield '5 Ingredients' => ['meritoo_common.general.ingredient', ['count' => 5], 'words', 'Ingredients'];
        yield '100 Ingredients' => ['meritoo_common.general.ingredient', ['count' => 100], 'words', 'Ingredients'];

        // Picture
        yield '0 Pictures' => ['meritoo_common.general.picture', ['count' => 0], 'words', 'Pictures'];
        yield '1 Picture' => ['meritoo_common.general.picture', ['count' => 1], 'words', 'Picture'];
        yield '2 Pictures' => ['meritoo_common.general.picture', ['count' => 2], 'words', 'Pictures'];
        yield '5 Pictures' => ['meritoo_common.general.picture', ['count' => 5], 'words', 'Pictures'];
        yield '100 Pictures' => ['meritoo_common.general.picture', ['count' => 100], 'words', 'Pictures'];

        // Photo
        yield '0 Photos' => ['meritoo_common.general.photo', ['count' => 0], 'words', 'Photos'];
        yield '1 Photo' => ['meritoo_common.general.photo', ['count' => 1], 'words', 'Photo'];
        yield '2 Photos' => ['meritoo_common.general.photo', ['count' => 2], 'words', 'Photos'];
        yield '5 Photos' => ['meritoo_common.general.photo', ['count' => 5], 'words', 'Photos'];
        yield '100 Photos' => ['meritoo_common.general.photo', ['count' => 100], 'words', 'Photos'];

        // Certificate
        yield '0 Certificates' => ['meritoo_common.general.certificate', ['count' => 0], 'words', 'Certificates'];
        yield '1 Certificate' => ['meritoo_common.general.certificate', ['count' => 1], 'words', 'Certificate'];
        yield '2 Certificates' => ['meritoo_common.general.certificate', ['count' => 2], 'words', 'Certificates'];
        yield '5 Certificates' => ['meritoo_common.general.certificate', ['count' => 5], 'words', 'Certificates'];
        yield '100 Certificates' => ['meritoo_common.general.certificate', ['count' => 100], 'words', 'Certificates'];

        // Message
        yield '0 Messages' => ['meritoo_common.general.message', ['count' => 0], 'words', 'Messages'];
        yield '1 Message' => ['meritoo_common.general.message', ['count' => 1], 'words', 'Message'];
        yield '2 Messages' => ['meritoo_common.general.message', ['count' => 2], 'words', 'Messages'];
        yield '5 Messages' => ['meritoo_common.general.message', ['count' => 5], 'words', 'Messages'];
        yield '100 Messages' => ['meritoo_common.general.message', ['count' => 100], 'words', 'Messages'];

        // Day
        yield '0 Days' => ['meritoo_common.general.day', ['count' => 0], 'words', 'Days'];
        yield '1 Day' => ['meritoo_common.general.day', ['count' => 1], 'words', 'Day'];
        yield '2 Days' => ['meritoo_common.general.day', ['count' => 2], 'words', 'Days'];
        yield '5 Days' => ['meritoo_common.general.day', ['count' => 5], 'words', 'Days'];
        yield '100 Days' => ['meritoo_common.general.day', ['count' => 100], 'words', 'Days'];

        // Month
        yield '0 Months' => ['meritoo_common.general.month', ['count' => 0], 'words', 'Months'];
        yield '1 Month' => ['meritoo_common.general.month', ['count' => 1], 'words', 'Month'];
        yield '2 Months' => ['meritoo_common.general.month', ['count' => 2], 'words', 'Months'];
        yield '5 Months' => ['meritoo_common.general.month', ['count' => 5], 'words', 'Months'];
        yield '100 Months' => ['meritoo_common.general.month', ['count' => 100], 'words', 'Months'];

        // Year
        yield '0 Years' => ['meritoo_common.general.year', ['count' => 0], 'words', 'Years'];
        yield '1 Year' => ['meritoo_common.general.year', ['count' => 1], 'words', 'Year'];
        yield '2 Years' => ['meritoo_common.general.year', ['count' => 2], 'words', 'Years'];
        yield '5 Years' => ['meritoo_common.general.year', ['count' => 5], 'words', 'Years'];
        yield '100 Years' => ['meritoo_common.general.year', ['count' => 100], 'words', 'Years'];

        // Transaction
        yield '0 Transactions' => ['meritoo_common.finances.transaction', ['count' => 0], 'words', 'Transactions'];
        yield '1 Transaction' => ['meritoo_common.finances.transaction', ['count' => 1], 'words', 'Transaction'];
        yield '2 Transactions' => ['meritoo_common.finances.transaction', ['count' => 2], 'words', 'Transactions'];
        yield '5 Transactions' => ['meritoo_common.finances.transaction', ['count' => 5], 'words', 'Transactions'];
        yield '100 Transactions' => ['meritoo_common.finances.transaction', ['count' => 100], 'words', 'Transactions'];

        // Page
        yield '0 Pages' => ['meritoo_common.pagination.page', ['count' => 0], 'words', 'Pages'];
        yield '1 Page' => ['meritoo_common.pagination.page', ['count' => 1], 'words', 'Page'];
        yield '2 Pages' => ['meritoo_common.pagination.page', ['count' => 2], 'words', 'Pages'];
        yield '5 Pages' => ['meritoo_common.pagination.page', ['count' => 5], 'words', 'Pages'];
        yield '100 Pages' => ['meritoo_common.pagination.page', ['count' => 100], 'words', 'Pages'];
    }

    public function provideSingulars(): \Generator
    {
        yield 'Name' => ['meritoo_common.general.name', 'words', 'pl', 'Nazwa'];
        yield 'Title' => ['meritoo_common.general.title', 'words', 'pl', 'Tytuł'];
        yield 'Version' => ['meritoo_common.general.version', 'words', 'pl', 'Wersja'];
    }

    public function provideSingularsForDefaultLocale(): \Generator
    {
        yield 'Name' => ['meritoo_common.general.name', 'words', 'Name'];
        yield 'Title' => ['meritoo_common.general.title', 'words', 'Title'];
        yield 'Version' => ['meritoo_common.general.version', 'words', 'Version'];
    }

    /**
     * @dataProvider providePlurals
     */
    public function testPlurals(
        string $key,
        array $parameters,
        string $domain,
        string $locale,
        string $expected
    ): void {
        self::assertSame($expected, $this->translator->trans($key, $parameters, $domain, $locale));
    }

    /**
     * @dataProvider providePluralsForDefaultLocale
     */
    public function testPluralsUsingDefaultLocale(
        string $key,
        array $parameters,
        string $domain,
        string $expected
    ): void {
        self::assertSame($expected, $this->translator->trans($key, $parameters, $domain));
    }

    /**
     * @dataProvider provideSingulars
     */
    public function testSingulars(string $key, string $domain, string $locale, string $expected): void
    {
        self::assertSame($expected, $this->translator->trans($key, [], $domain, $locale));
    }

    /**
     * @dataProvider provideSingularsForDefaultLocale
     */
    public function testSingularsUsingDefaultLocale(string $key, string $domain, string $expected): void
    {
        self::assertSame($expected, $this->translator->trans($key, [], $domain));
    }

    protected function setUp(): void
    {
        parent::setUp();
        static::bootKernel();

        $this->translator = self::getContainer()->get(TranslatorInterface::class);
    }
}
