import { Form } from 'react-bootstrap';


function BookComponent(props) {
    return (
        <Form.Group className="mb-3" controlId="Weight">
            <Form.Label>Weight (KG)</Form.Label>
            <Form.Control
                required
                // type='number'
                // step={0.01}
                className="productDataEntry numberEntry"
                placeholder="Enter Weight"
                onChange={(e) => {
                    props.data({ "weight": e.target.value });
                }}
            />
        </Form.Group>
    )
}

export default BookComponent;
