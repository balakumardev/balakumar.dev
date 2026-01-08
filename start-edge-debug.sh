#!/bin/bash

# Edge Browser Debug Launcher
# Launches Microsoft Edge with remote debugging enabled for Chrome DevTools MCP

PROJECT_DIR="$(cd "$(dirname "$0")" && pwd)"
PORT_FILE="$PROJECT_DIR/.edge-debug-port"
PROFILE_DIR="$PROJECT_DIR/.edge-debug-profile"

# Generate a unique port based on project path hash (range 9222-9999)
if [ ! -f "$PORT_FILE" ]; then
    HASH=$(echo -n "$PROJECT_DIR" | md5 | cut -c1-4)
    PORT=$((16#$HASH % 778 + 9222))
    echo "$PORT" > "$PORT_FILE"
else
    PORT=$(cat "$PORT_FILE")
fi

echo "Debug port: $PORT"
echo "Profile directory: $PROFILE_DIR"

# Check if Edge is already running with debugging on this port
if lsof -i ":$PORT" > /dev/null 2>&1; then
    echo "Edge is already running with debugging on port $PORT"
    echo "To restart, close Edge and run this script again"
    exit 0
fi

# Create profile directory if it doesn't exist
mkdir -p "$PROFILE_DIR"

# Launch Edge with remote debugging
echo "Launching Microsoft Edge with remote debugging..."
"/Applications/Microsoft Edge.app/Contents/MacOS/Microsoft Edge" \
    --remote-debugging-port="$PORT" \
    --user-data-dir="$PROFILE_DIR" \
    --no-first-run \
    --no-default-browser-check \
    "$@" &

echo "Edge launched with remote debugging on port $PORT"
echo "You can now use Chrome DevTools MCP to interact with the browser"
