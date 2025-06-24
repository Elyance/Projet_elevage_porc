# Projet_elevage_porc
projet S4 Mme Baovola

## Comment vous connecter à la branche dev dans VS Code

1. Ouvrez le dossier du projet dans VS Code.
2. Ouvrez le terminal intégré (`Ctrl + ``).
3. Vérifiez les branches disponibles :
   ```bash
   git branch
   ```
4. Si la branche `dev` existe, passez dessus :
   ```bash
   git checkout dev
   ```
5. Si la branche `dev` n’existe pas localement, récupérez-la :
   ```bash
   git fetch
   git checkout dev
   ```
6. Assurez-vous d’être bien sur la branche `dev` :
   ```bash
   git branch
   ```