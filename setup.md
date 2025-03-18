# Setting Up Remote SSH in VS Code for The Give Hub Project

These instructions will guide you through setting up a remote SSH connection in VS Code to work with The Give Hub crowdfunding platform files, along with the Git workflow for feature development.

## Prerequisites

1. VS Code installed on your local machine
2. SSH access to the server (make sure you have login credentials)
3. Your SSH key added to your GitHub account for repository access

## Part 1: Setting Up Remote SSH in VS Code

### Step 1: Install the Remote Development Extension

1. Open VS Code
2. Click on the Extensions icon in the sidebar (or press Ctrl+Shift+X)
3. Search for "Remote Development"
4. Click "Install" on the "Remote Development" extension pack by Microsoft
5. Wait for the installation to complete (VS Code may need to reload)

### Step 2: Configure SSH Connection

1. Press Ctrl+Shift+P to open the Command Palette
2. Type "Remote-SSH: Open Configuration File" and select it
3. Select the first option for your SSH config file (usually `~/.ssh/config`)
4. Add the following configuration (replace placeholders with actual values):

```
Host givehub-server
    HostName [server-ip-address]
    User kev
    IdentityFile ~/.ssh/[your-private-key-filename]
    Port 22
```

5. Save the file (Ctrl+S)

### Step 3: Connect to the Server

1. Press Ctrl+Shift+P again
2. Type "Remote-SSH: Connect to Host"
3. Select "givehub-server" from the list
4. A new VS Code window will open. If prompted about the host authenticity, click "Continue"
5. If prompted for a password, enter it (or your SSH key passphrase if applicable)
6. Wait for VS Code to set up the connection (this might take a minute the first time)

### Step 4: Open The Give Hub Project Folder

1. When connected, click on "Open Folder" in VS Code
2. Navigate to `/home/kev/domains/thegivehgub.com/app-kev`
3. Click "OK"
4. Wait for VS Code to load the project files

### Step 5: Install Helpful PHP and MongoDB Extensions

In the remote VS Code window:
1. Go to Extensions (Ctrl+Shift+X)
2. Search for and install:
   - "PHP Intelephense" (or "PHP IntelliSense")
   - "PHP Debug"
   - "MongoDB for VS Code"

## Part 2: Setting Up Git for The Give Hub Project

### Step 1: Configure Git on the Server

1. Open the integrated terminal in VS Code (Ctrl+`)
2. Configure your Git identity:
```bash
git config --global user.name "Your Name"
git config --global user.email "your.email@example.com"
```

### Step 2: Clone The Give Hub Repository

1. In the integrated terminal, navigate to the appropriate directory:
```bash
cd /home/kev/domains/thegivehgub.com/
```

2. Clone the repository:
```bash
git clone git@github.com:thegivehub/app.git app-kev
```

3. If you've already cloned the repository but need to set the remote origin:
```bash
cd /home/kev/domains/thegivehgub.com/app-kev
git remote set-url origin git@github.com:thegivehub/app.git
```

4. Verify the remote is set correctly:
```bash
git remote -v
```
   It should show: `origin git@github.com:thegivehub/app.git (fetch)` and `origin git@github.com:thegivehub/app.git (push)`

## Part 3: Development Workflow for The Give Hub

### Creating a New Feature

1. Always start by pulling the latest changes from the main branch:
```bash
git checkout main
git pull origin main
```

2. Create a new branch for your feature:
```bash
git checkout -b feature/your-feature-name
```

3. Work on your changes using VS Code's editor

### Saving Your Work

1. Check which files you've modified:
```bash
git status
```

2. Add your changes:
```bash
git add .
```

3. Commit your changes with a descriptive message:
```bash
git commit -m "Add feature: detailed description of your changes"
```

4. Push your branch to GitHub:
```bash
git push -u origin feature/your-feature-name
```

### Creating a Pull Request

1. Go to [The Give Hub GitHub repository](https://github.com/thegivehub/app)
2. You should see a banner suggesting to create a PR for your recently pushed branch
3. Click "Compare & pull request"
4. Fill in:
   - Title: Clear description of the feature (e.g., "Add Stellar blockchain transaction viewer")
   - Description: Details about what the feature does and how it works
5. Click "Create pull request"

### Handling Feedback and Updates

If you receive feedback on your PR:

1. Make the requested changes in VS Code
2. Add and commit the changes:
```bash
git add .
git commit -m "Address feedback: describe the changes"
```

3. Push the changes:
```bash
git push
```

4. The PR will update automatically

## Troubleshooting Common Issues

### SSH Connection Problems

If you can't connect:
1. Verify your SSH key is in the correct location
2. Make sure you have the right server address and username
3. Check that your SSH key is added to the server's authorized_keys file

### Git Authentication Issues

If you get "Permission denied" errors with GitHub:
1. Verify your SSH key is added to your GitHub account
2. Test your SSH connection: `ssh -T git@github.com`
3. Make sure you're using the SSH URL (git@github.com:thegivehub/app.git) not HTTPS

### PHP/MongoDB Connection Issues

For database connection problems:
1. Check MongoDB connection settings in the project's configuration files
2. Verify MongoDB is running on the server: `sudo systemctl status mongodb`
3. Test connection via terminal: `mongo`

## Remember

- The Give Hub is a Stellar blockchain-based crowdfunding platform for social causes
- The project structure follows the domain-based organization pattern
- Always pull the latest changes before starting new work
- Create specific feature branches for each new development task
- Push regularly to avoid losing work

Feel free to reach out for help if you encounter any issues during setup!
