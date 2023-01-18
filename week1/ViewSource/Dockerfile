FROM nginx:stable

# Copy the HTML file and other static assets into the container
COPY index.html /usr/share/nginx/html/index.html

# Set the default command to run when the container starts
CMD ["nginx", "-g", "daemon off;"]