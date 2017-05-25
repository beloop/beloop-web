import React, { Component } from 'react';
import { IntlProvider } from 'react-intl';
import { Route } from 'react-router-dom';

import Course from './features/course/Course';
import ApiService from 'Services/http/api.service';

export default class App extends Component {
  constructor() {
    super();

    this.state = {
      translations: null,
    };
  }

  componentWillMount() {
    this.loadTranslations();
  }

  loadTranslations() {
    ApiService.get('translations', {}, { locale: 'en' }).then((response) => {
      this.setState({
        translations: response.body,
      });
    });
  }

  render() {
    let children;

    if (this.state.translations) {
      children = (
        <IntlProvider locale="en" messages={this.state.translations}>
          <Route exact path="/courses" component={Course} />
        </IntlProvider>
      );
    }

    return (<div>{children}</div>);
  }
}
