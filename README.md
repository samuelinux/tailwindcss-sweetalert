# TailwindCSS + SweetAlert2 for Laravel

[![License: MIT](https://img.shields.io/badge/License-MIT-blue.svg)](LICENSE)
[![PHP](https://img.shields.io/badge/PHP-^8.1-777BB4.svg)](https://php.net)
[![Laravel](https://img.shields.io/badge/Laravel-10|11|12-FF2D20.svg)](https://laravel.com)
[![Livewire](https://img.shields.io/badge/Livewire-^3.0-FB70A9.svg)](https://livewire.laravel.com)

Pacote Laravel que injeta automaticamente **TailwindCSS** e **SweetAlert2** em toda resposta HTML. Zero configuração — basta instalar.

## ✨ Funcionalidades

- **TailwindCSS v2.2** — injetado via `<link>` com cache de 1 ano
- **SweetAlert2** — injetado via `<script src>` com cache de 1 ano
- **Macros Livewire** — `$this->alert()` e `$this->confirm()` em qualquer componente
- **Zero configuração** — sem Vite, sem NPM, sem CDN, sem tags manuais
- **Performance otimizada** — assets cacheados pelo browser após primeira visita
- **100% encapsulado** — todos os assets ficam no `vendor/`

---

## 🚀 Instalação

```bash
composer require samuelpereiramachado/tailwindcss-sweetalert
```

Pronto. O Service Provider é registrado automaticamente via Laravel Package Discovery.

---

## 🔧 Uso

### Alertas

Em qualquer componente Livewire:

```php
// Alerta simples
$this->alert('Sucesso!', 'Operação realizada com sucesso.', 'success');

// Com opções do SweetAlert2
$this->alert('Aviso', 'Atenção ao prazo.', 'warning', [
    'timer' => 3000,
    'showConfirmButton' => false,
]);
```

### Confirmações

```php
$this->confirm(
    title: 'Tem certeza?',
    action: ['method' => 'delete', 'params' => $id],
    message: 'Esta ação não pode ser desfeita.',
    type: 'warning'
);
```

Implemente o método de callback:

```php
public function delete($id)
{
    Model::findOrFail($id)->delete();
    $this->alert('Excluído!', 'Registro removido.', 'success');
}
```

**Tipos disponíveis:** `success` · `error` · `warning` · `info` · `question`

---

## ⚙️ Como funciona

O pacote registra um **middleware global** que intercepta toda resposta HTML e injeta automaticamente:

1. `<link rel="stylesheet" href="/tailwindcss-sweetalert/css">` antes de `</head>`
2. `<script src="/tailwindcss-sweetalert/js">` + event listeners antes de `</body>`

Os assets são servidos com `Cache-Control: max-age=31536000, immutable` — ou seja, o browser baixa **uma única vez** e cacheia por 1 ano.

---

## 🏗️ Estrutura

```
├── composer.json
├── resources/
│   ├── css/tailwind.css                  # TailwindCSS v2.2 compilado
│   └── js/sweetalert2.all.min.js         # SweetAlert2 bundled
└── src/
    ├── TailwindcssSweetalertServiceProvider.php
    └── Http/
        ├── Controllers/
        │   └── AssetController.php       # Serve assets com cache 1 ano
        └── Middleware/
            └── InjectAssets.php          # Auto-injeta <link> e <script>
```

---

## 📋 Requisitos

| Dependência | Versão       |
| ----------- | ------------ |
| PHP         | >= 8.1       |
| Laravel     | 10, 11 ou 12 |
| Livewire    | >= 3.0       |

---

## 📄 Licença

MIT — veja [LICENSE](LICENSE) para detalhes.

---

**Autor:** Samuel Pereira Machado
