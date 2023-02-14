# SolutionStatusType

Typ enumeryczny reprezentujący status rozwiązania.

```php
final class SolutionStatusType extends Enum
{
    // Puste rozwiązanie - default-owy status określony już na poziomie migracji
    public const EMPTY = 0;
    // Otrzymany, rozwiązanie przyjmuje taki status, kiedy rozpoczyna się walidacja
    public const RECEIVED = 1;
    // Zwalidowany, rozwiązanie jest poprawne pod względem formatu i wymagań odnośnie do czasu wykonania i pamięci
    public const VALIDATED = 2;
    // Rozwiązanie zostało przesłane dla niedozwolonego języka
    public const INVALID_LANGUAGE_USED = 3;
    // Za dużo znaków w rozwiązaniu
    public const CHARACTERS_LIMIT_EXCEEDED = 4;
    // Błąd podczas dekodowania rozwiązania z base64
    public const EMPTY_DECODING_RESULT = 5;
    // Niepoprawny wynik dekodowania 
    public const MALFORMED_UTF8_CODE_STRING = 6;
    // Mniej szczegółowy statu odnośnie do błędu
    public const INVALID = 7;
    // Oddelegowane do egzekutora
    public const DELEGATED = 8;
    // Poprawnie przeszło testy
    public const PASSED_ALL_TESTS = 9;
    // Przynajmniej jeden test zwrócił błąd
    public const FAILED_TESTS = 10;
    // Przerwane, błąd w działaniu aplikacji spowodował naruszenie integralności danych
    public const INTERRUPTED = 11;
}
```