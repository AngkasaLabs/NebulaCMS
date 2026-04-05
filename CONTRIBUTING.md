# NebulaCMS Contribution Guidelines
Thank you for considering contributing to NebulaCMS! We greatly appreciate every contribution from the community.

## 🤝 How to Contribute

### 1. Fork & Clone
- Fork repositori NebulaCMS
- Clone your fork to local
```bash
git clone https://github.com/AngkasaLabs/NebulaCMS.git
cd NebulaCMS
```

### 2. Setup Development Environment
```bash
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
```

### 3. Create a Branch
```bash
git checkout -b feature-name
# atau
git checkout -b fix-issue
```

### 4. Coding Guidelines
- Follow PSR-12 for PHP
- Use TypeScript for frontend code
- Ensure the code is formatted with Prettier
- Write tests for new features
- Ensure all tests pass
```bash
php artisan test
npm run test
```

### 5. Commit Guidelines
Format commit message:
```
type(scope): description

[optional body]
[optional footer]
```

Types:
- feat: New feature
- fix: Bug fix
- docs: Documentation changes
- style: Formatting, missing semicolons, etc.
- refactor: Code refactoring
- test: Add/update tests
- chore: Changes to build process or tools

### 6. Submit Pull Request
- Push to your fork
- Create a Pull Request to the main repository
- Describe the changes clearly
- Link to related issues if any

## 🐛 Reporting Bugs
- Use the bug report template
- Include reproduction steps
- Include expected vs actual behavior
- Include screenshots if possible

## 💡 Suggesting Features
- Use the feature request template
- Explain the use case
- Explain the proposed solution
- Consider alternatives you have thought of

## 📝 Documentation
- Documentation is located in the `/docs` folder
- Use Markdown
- Follow the documentation writing guidelines

## ⚖️ License
By contributing, you agree that your contributions will be licensed under the MIT License.

## 💬 Questions?
- Create an issue on GitHub
- Send an email to maintainers@angkasalabs.com 
