import Card from 'react-bootstrap/Card';
// import { ToggleButton } from 'react-bootstrap';
import { useState, useEffect } from 'react';

function Product(props) {

    const [checked, setChecked] = useState(false);
    useEffect(() => {
    }, [checked]);

    const handleFormat = (value, key) => {
        switch (key) {
            case 'dimensions':
                return value + "CM";
            case 'weight':
                return value + "KG";
            case 'price':
                return value + "$"
            case 'size':
                return value + "MB"
            case 'type':
                if (key === 'dvd') return value.toUpperCase()
                else return value.replace(/^\w/, c => c.toUpperCase())
            default:
                return value
        }
    }

    const handleCheckbox = (e) => {
        setChecked(e.currentTarget.checked);
        props.isSelected({
            "product": props.product.SKU,
            "isChecked": e.target.checked
        });
    }

    return (
        <>
            <Card
                bg={"light"}
                key={"Card" + props.product.SKU}
                text={"dark"}
                style={{ 
                    width: '18rem',
                    boxShadow: '3px 3px 3px lightGray'
                }}
                className="mb-2"
            >
                <Card.Header as="h5">
                    <input
                        style={{ "marginRight": "10px", "width": "15px", "height": "15px" }}
                        id={'checkbox' + props.product.SKU}
                        type="checkbox"
                        className='delete-checkbox justify-content-end'
                        onChange={(e) => handleCheckbox(e)}></input>
                    {props.product.name.replace(/^\w/, c => c.toUpperCase())}</Card.Header>
                <Card.Body>
                    {Object.keys(props.product).map((key, _) => (
                        <Card.Text key={key}>
                            {key.replace(/^\w/, c => c.toUpperCase()) + ": " + handleFormat(props.product[key], key)}
                        </Card.Text>
                    ))}
                </Card.Body>
            </Card>
        </>
    );
}

export default Product;