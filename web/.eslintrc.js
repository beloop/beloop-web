module.exports = {
  "settings": {
    "import/resolver": "webpack"
  },
  "extends": "airbnb",
  "plugins": [
    "react",
    "jsx-a11y",
    "import"
  ],
  "rules": {
    "arrow-parens": [ "error", "always" ],
    "max-len": [ "warn", 140 ],
    "react/prop-types": 0
  },
  "globals": {
    "document": true,
    "window": true
  }
};
