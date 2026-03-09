If you've run:

```bash
composer global require laravel/installer
```

but `laravel new` still says `laravel: command not found`, it's most likely because the global Composer `vendor/bin` directory isn't in your system's PATH.

### ✅ Fix for macOS

Add this to your shell profile based on what shell you're using:

#### 1. **Find your Composer global bin path:**

Run:
```bash
composer global config bin-dir --absolute
```

You’ll get something like:
```
/Users/yourname/.composer/vendor/bin
```
or
```
/Users/yourname/.config/composer/vendor/bin
```

#### 2. **Add it to your PATH**

Depending on your shell, edit the appropriate config file:

- For **zsh** (default in recent macOS):  
  Add to `~/.zshrc`

- For **bash**:  
  Add to `~/.bash_profile` or `~/.bashrc`

Add this line:
```bash
export PATH="$PATH:$HOME/.composer/vendor/bin"
```
Or if you saw `.config/composer/vendor/bin`, use:
```bash
export PATH="$PATH:$HOME/.config/composer/vendor/bin"
```

#### 3. **Reload your shell configuration:**

For zsh:
```bash
source ~/.zshrc
```

For bash:
```bash
source ~/.bash_profile
```

#### 4. **Verify it's working:**

```bash
laravel
```

You should see the Laravel installer CLI output.

---

Would you like help creating a new Laravel project after this?
