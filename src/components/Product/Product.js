import Card from 'react-bootstrap/Card';
// import { ToggleButton } from 'react-bootstrap';
import { useState, useEffect } from 'react';

function Product(props) {
    const [checked, setChecked] = useState(false);
    useEffect(() => {
    }, [checked]);

    const cm = ['length', 'width', 'height'];
    const kg = ['weight'];
    const usd = ['price'];
    const mb = ['size'];

    const addUnit = (key) => {
        if (cm.includes(key)) {
            return "CM"
        } else if (kg.includes(key)) {
            return "KG"
        } else if (usd.includes(key)) {
            return "$"
        }
        else if (mb.includes(key)) {
            return "MB"
        }
        else {
            return ""
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
                style={{ width: '18rem' }}
                className="mb-2"
            >
                <Card.Header>
                    <input
                        id={'checkbox' + props.product.SKU}
                        type="checkbox"
                        className='.delete-checkbox'
                        onChange={(e) => handleCheckbox(e)}></input>
                    {props.product.name.replace(/^\w/, c => c.toUpperCase())}</Card.Header>
                <Card.Body>
                    <Card.Title>Details</Card.Title>
                    {Object.keys(props.product).map((key, _) => (
                        <Card.Text key={key}>
                            {key.replace(/^\w/, c => c.toUpperCase()) + ": " + props.product[key] + addUnit(key)}
                        </Card.Text>
                    ))}
                </Card.Body>
            </Card>
        </>
    );
}

export default Product;