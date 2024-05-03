import React from 'react';

import IconComponent from '../components/IconComponent';

function TaxTableComponent(props) {
  const { terms } = props;

  return (
    Array.isArray(terms) && (
      <table>
        <tbody>
          {terms.map((tax, index) => (
            <tr>
              <td>
                <IconComponent key={index} icon={tax.icon} url={tax.url} />
              </td>
              <td>
                <h3>{tax.title}</h3>
              </td>
            </tr>
          ))}
        </tbody>
      </table>
    )
  );
}

export default TaxTableComponent;
