import { Form } from 'react-bootstrap';


function DVDComponent(props) {
    return (
        <Form.Group className="mb-3" controlId="#size">
            <Form.Label>Size (MB)</Form.Label>
            <Form.Control
                // id='#size'
                required
                // type='number'
                // step={0.01}
                className="productDataEntry numberEntry"
                placeholder="Enter Size"
                onChange={(e) => {
                    props.data({ "size": e.target.value });
                }}
            />
        </Form.Group>
    )
}

export default DVDComponent;
